<?php

namespace App\Http\Components\Traits;

use App\Models\UserPicture;

trait UserUpload{
    /**
     * Upload Picture
     */
    protected function uploadPic($image_path, $user_id, $is_profile_pic = false){
        if($is_profile_pic){
            UserPicture::where("user_id", $user_id)->update(["is_profile_picture" => false]);
        }
        $picture = new UserPicture();
        $picture->user_id = $user_id; 
        $picture->path = $image_path;
        $picture->is_profile_picture = $is_profile_pic;
        $picture->save();
        return $picture;
    }

    /**
     * Upload Multiple Picture
     */
    protected function uploadMultiplePic($image_path_arr, $user_id){
        foreach($image_path_arr as $path){
            $picture = new UserPicture();
            $picture->user_id = $user_id; 
            $picture->path = $path;
            $picture->is_profile_picture = false;
            $picture->save();
        }
    }
}