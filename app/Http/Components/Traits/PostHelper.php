<?php

namespace App\Http\Components\Traits;

use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostLike;
use App\Models\PostUploads;
use App\Models\ReplyCommentLike;
use App\Models\User;
use App\Models\UserPicture;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

use function PHPUnit\Framework\isJson;

trait PostHelper{

    use Upload, UserUpload, NotificationHelper;

    /**
     * Store New Or Update Post Information
     * @return Post Info
     */
    protected function savePost($user, $request){
        if( !empty($request->id) ){
            $post = Post::where("id", $request->id)->first();
        }else{
            $post = new Post();
            $slug_text = !empty($request->title) ? $user->id.'-'.$request->title : $user->id.'-'.time();
            $post->slug = Str::slug($slug_text);
        }
        $post->user_id  = $user->id;
        $post->title    = $request->title;
        $post->post     = $request->post;
        $post->type     = $request->type;
        $post->tags     = [];
        $post->save();
        PostCategory::where("post_id", $post->id)->delete();
        if( isJson($request->tags) && !empty($request->tags)){
            $data_list = json_decode($request->tags);
            if(count($data_list) > 0){
                foreach($data_list as $int_cat_id){
                    $post_category = new PostCategory();
                    $post_category->post_id = $post->id;
                    $post_category->interest_category_id = $int_cat_id;
                    $post_category->save();
                }
            }
        }
        return $post;
    }

    /**
     * upload post Images
     */
    protected function postUploads($post, $img_path_arr){
        foreach($img_path_arr as $path){
            $picture = $this->uploadPic($path, $post->user_id);

            $post_image = new PostUploads();
            $post_image->post_id = $post->id;
            $post_image->user_picture_id = $picture->id;
            $post_image->save();
        }
    }

    /**
     * Get Post Upoads
     * @return Upload Files Path Array
     */
    protected function getPostUploads($post){
        $path_arr = [];
        foreach($post->post_uploads as $post_upload){
            if(isset($post_upload->user_picture->path)){
                $path_arr[] = $post_upload->user_picture->path ?? "";
            }
        }
        return $path_arr;
    }

    /**
     * Delete All Uploads Of a post
     */
    protected function deleteUploads($post){
        foreach($post->post_uploads as $uploads){
            $user_upload = $uploads->user_picture;
            $this->RemoveFile($user_upload->path);
            $user_upload->delete();
            $uploads->delete();
        }
    }

    /**
     * Like on a post
     */
    protected function likeOnPost($post, $user, $like = true){
        $post_like = PostLike::where('user_id', $user->id)->where('post_id', $post->id)->first();
        $send_notification = false;
        $already_liked = false;
        if( empty($post_like) ){
            $post_like = new PostLike();
            $post_like->user_id = $user->id;
            $post_like->post_id = $post->id;
            $post->save();
            $send_notification = true;
        }else{
            $already_liked = $post_like->is_like;
        }
        if($like){
            $post->total_likes = $like ? ($post->total_likes + 1) : $post->total_likes;
            $post_like->is_like = true;
            $post_like->is_dislike = false;
        }else{
            if($already_liked){
                $post->total_likes = !$like ? ($post->total_likes - 1) : $post->total_likes;
            }
            $post_like->is_like = false;
            $post_like->is_dislike = true;
        }
        $post_like->save();

        if($like && $send_notification){
            $post_author = User::find($post->user_id);
            $notification_smg = Lang::get("message.like_on_post",["name" => $user->first_name], $post_author->app_lanuage ?? "de");
            $this->sendPostNotification($post_author, $user->id, $post, $notification_smg);
        }
    }

    /**
     * Like on a post
     */
    protected function commentOnPost($post, $request){
        $user = $request->user();
        $comment = new Comment();
        $comment->user_id   = $user->id;
        $comment->post_id   = $post->id;
        $comment->comment   = $request->comment;

        if($request->hasFile("upload_file")){
            $path = $this->uploadFile($request, "upload_file", $this->other_image_dir);
            $user_picture = $this->uploadPic($path, $user->id);
            $comment->user_picture_id = $user_picture->id;
        }
        $comment->save();
        $post_author = User::find($post->user_id);
        $notification_smg = Lang::get("message.comment_on_post",["name" => $user->first_name], $post_author->app_lanuage ?? "de");
        $this->sendPostNotification($post_author, $user->id, $post, $notification_smg, "comment");
        return $comment;
    }

    /**
     * Change Post Block Status
     */
    protected function blockStatusChange($post_id,$status){
        Post::where('id',$post_id)->update(['is_block'=>$status]);
    }

    /**
     * Check The Authenticate User is Liked or not on the post
     * @return true | false
     */
    protected function isLiked($post_id){
        $data = PostLike::where("post_id", $post_id)->where("user_id", Auth::user()->id)->where("is_like", true)->first();
        if( !empty($data) ){
            return true;
        }
        return false;
    }

    /**
     * Check The Authenticate User is Liked or not on the post
     * @return true | false
     */
    protected function isDisliked($post_id){
        $data = PostLike::where("post_id", $post_id)->where("user_id", Auth::user()->id)->where("is_dislike", true)->first();
        if( !empty($data) ){
            return true;
        }
        return false;
    }

    public function getPost($post_id)
    {
        return Post::withTrashed()->find($post_id);
    }

    public function getUser($user_id)
    {
        return User::find($user_id);
    }

    /**
     * Like On Comment
     */
    public function likeOnPostComment($request, $is_like = true){
        $comment_like = CommentLike::where("user_id", Auth::user()->id)
            ->where("post_id", $request->post_id)->where("comment_id", $request->comment_id)->first();
        if( empty($comment_like) ){
            $comment_like = new CommentLike();
        }
        $comment_like->user_id      = Auth::user()->id;
        $comment_like->post_id      = $request->post_id;
        $comment_like->comment_id   = $request->comment_id;
        $comment_like->is_like      = $is_like;
        $comment_like->save();


        return $comment_like;
    }

    /**
     * Like On a Comment's Reply
     */
    public function likeOnPostCommentReply($request, $is_like = true){
        $reply_like = ReplyCommentLike::where("user_id", Auth::user()->id)
            ->where("post_id", $request->post_id)->where("comment_id", $request->comment_id)
            ->where("comment_reply_id", $request->reply_id)->first();
        if( empty($reply_like) ){
            $reply_like = new ReplyCommentLike();
        }
        $reply_like->user_id      = Auth::user()->id;
        $reply_like->post_id      = $request->post_id;
        $reply_like->comment_id   = $request->comment_id;
        $reply_like->comment_reply_id = $request->reply_id;
        $reply_like->is_like      = $is_like;
        $reply_like->save();
        return $reply_like;
    }

    /**
     * Check like on Post Comment
     */
    public function isLikeOnPostComment($comment){
        $comment_like = CommentLike::where("user_id", Auth::user()->id)
            ->where("post_id", $comment->post_id)
            ->where("comment_id", $comment->id)
            ->where("is_like", true)->first();
        if( !empty($comment_like) ){
            return true;
        }
        return false;
    }
}
