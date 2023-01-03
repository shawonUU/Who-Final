<?php

namespace App\Http\Components\Traits;

use App\Models\AccountDeleteInfo;
use App\Models\ChatList;
use App\Models\ConnectionRequest;
use App\Models\User;
use App\Models\UserBlockList;
use App\Models\UserConnection;
use App\Models\UserInterest;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isJson;

trait Profile{

    use UserUpload, ChatHelper;
    /**
     * Create Profile || Register Profile | Create Account
     * @return $user
     */
    protected function createAccount($request){
        $user = $this->getUser($request->phone_email);
        if( filter_var($request->phone_email, FILTER_VALIDATE_EMAIL) ){
            $user->email = $request->phone_email;
            $user->password = bcrypt($request->password);
            $user->email_verified_at = now();
        }else{
            $user->phone = $request->phone_email;
            $user->phone_verified_at = now();
        }
        $user->device_info = $request->device_name;
        $user->login_at = now();
        $user->is_online = true;
        $this->storeFCMID($user, $request);
        $user->save();
        return $user;
    }

    /**
     * Store Or Update FCM ID
     * @return $user
     */
    protected function storeFCMID($user, $request){
        $user->fcm_id = $request->fcm_id ?? $user->fcm_id;
        $user->ios_fcm_id = $request->ios_fcm_id ?? $user->ios_fcm_id;
    }

    /**
     * Profile Exists
     */
    protected function getUser($phone_email){
        $user = User::where("email", $phone_email)->orWhere("phone", "like", '%'.$phone_email)->first();
        if( !empty($user) ){
            return $user;
        }
        return new User();
    }

    /**
     * Get Profile Details with All Upload Files
     * @return $user
     */
    protected function getFullProfileInfo($user){
        $profile_pic =  isset($user->profile_picture->path) ? asset($user->profile_picture->path) : null;
        $user->profile_pic = $profile_pic;
        unset($user->profile_picture);
        $user->user_interest = $user->user_interests ?? [];
        $user->uploads =  $this->getUploadedImages($user);
        return $user;
    }

    /**
     * Get Profile Info without Upload Files
     * @return $user
     */
    protected function getProfileInfo($user){
        $profile_pic =  isset($user->profile_picture->path) ? asset($user->profile_picture->path) : null;
        $user->profile_pic = $profile_pic;
        unset($user->profile_picture);
        $user->user_interest = $user->user_interests ?? [];
        return $user;
    }

    /**
     * get All Upload Images
     */
    protected function getUploadedImages($user){
        $images = [];
        foreach($user->pictures as $image){
            $images[] = $image->path;
        }
        unset($user->pictures);
        $user->uploads = $images;
        return $images;
    }

    /**
     * Update Incomplete Profile
     * @return $User
     */
    protected function incompleteUpdate($user, $request){
        $user->first_name       = $request->first_name ?? $user->first_name;
        $user->last_name        = $request->last_name ?? $user->last_name;
        $user->email            = $request->email ?? $user->email;
        if(!empty($request->password)){
            $user->password         = bcrypt($request->password);
        }
        $user->phone            = $request->phone ?? $user->phone;
        $user->date_of_birth    = $request->date_of_birth ?? $user->date_of_birth;
        $user->gender           = $request->gender ?? $user->gender;
        $user->relation_ship    = $request->relation_ship ?? $user->relation_ship;
        $user->height           = $request->height ?? $user->height;
        $user->weight           = $request->weight ?? $user->weight;
        $user->education        = $request->education ?? $user->education;

        $user->looking_for      = isJson($request->looking_for) ? json_decode($request->looking_for) : ( is_array($request->looking_for) ? $request->looking_for : []);
        $user->about_me         = $request->about_me ?? $user->about_me;
        $user->ocupation        = $request->ocupation ?? $user->ocupation;
        $user->state            = $request->state ?? $user->state;
        $user->city             = $request->city ?? $user->city;
        $user->address          = $request->address ?? $user->address;
        $user->nationality      = $request->nationality ?? $user->nationality;
        $user->religion         = $request->religion  ?? $user->religion ;
        $user->religion_id      = $request->religion_id  ?? $user->religion_id ;
        $user->country_id       = $request->country_id  ?? $user->country_id ;
        $user->language         = $request->language ?? $user->language;
        $user->longitude        = $request->longitude ?? $user->longitude;
        $user->latitude         = $request->latitude ?? $user->latitude;
        $user->app_lanuage      = $request->app_lanuage ?? $user->app_lanuage;
        $user->device_info      = $request->device_info ?? $user->device_info;
        $this->storeFCMID($user, $request);
        $user->save();
        $this->saveUserInterest($user, $request);
        return $user;
    }

    /**
     * Update Profile
     * @return $User
     */
    protected function update($user, $request){

        if( !empty($request->email) || !empty($request->phone) ){
            $user->email            = $request->email;
            $user->phone            = $request->phone;
        }
        if(!empty($request->password)){
            $user->password         = bcrypt($request->password);
        }
        $user->first_name       = $request->first_name;
        $user->last_name        = $request->last_name;
        $user->date_of_birth    = $request->date_of_birth;
        $user->gender           = $request->gender;
        $user->relation_ship    = $request->relation_ship;
        $user->height           = $request->height;
        $user->weight           = $request->weight;
        $user->education        = $request->education;
        $user->looking_for      = isJson($request->looking_for) ? json_decode($request->looking_for) : ( is_array($request->looking_for) ? $request->looking_for : []);
        $user->about_me         = $request->about_me;
        $user->ocupation        = $request->ocupation;
        $user->state            = $request->state;
        $user->city             = $request->city;
        $user->address          = $request->address;
        $user->nationality      = $request->nationality;
        $user->religion         = $request->religion;
        $user->religion_id      = $request->religion_id;
        $user->country_id       = $request->country_id;
        $user->language         = $request->language;
        $user->longitude        = $request->longitude;
        $user->latitude         = $request->latitude;
        $user->app_lanuage      = $request->app_lanuage;
        $user->device_info      = $request->device_info;
        $this->storeFCMID($user, $request);
        $user->save();
        $this->saveUserInterest($user, $request);
        return $user;
    }

    /**
     * Add Or Update User Interest Category
     */
    public function saveUserInterest($user, $request){
        if(!empty($request->user_interest)){
            UserInterest::where("user_id", $user->id)->delete();
            $interest_list_arr = isJson($request->user_interest) ? json_decode($request->user_interest) : (is_array($request->user_interest) ? $request->user_interest : []);
            foreach($interest_list_arr as $interest_id){
                $data = UserInterest::where('interest_categorie_id', $interest_id)->where("user_id", $user->id)->first();
                if( !empty($data) ){
                    continue;
                }
                $data = new UserInterest();
                $data->user_id = $user->id;
                $data->interest_categorie_id = $interest_id;
                $data->save();
            }
        }
    }

    /**
     * Check the user is Friend Or Not
     * @return boolean
     */
    protected function is_friend($user_id){
        $to_user = Auth::user()->id ?? $user_id;
        if($user_id == $to_user){
            return false;
        }
        $data = UserConnection::where(function($qry) use($to_user, $user_id){
            $qry->where("user_id", $to_user)->where("connected_user_id", $user_id);
        })
        ->orWhere(function($qry) use($to_user, $user_id){
            $qry->where("user_id", $user_id)->where("connected_user_id", $to_user);
        })->first();
        if( empty($data) ){
            return false;
        }
        return true;
    }

    /**
     * Check User Block Status
     * @return UserBlockList Model
     */
    protected function getBlockData($sender, $receiver){
        return UserBlockList::where("status", "block")->where(function($qry)use($receiver, $sender){
            $qry->where(function($qry)use($receiver, $sender){
                $qry->where("user_id", $sender->id)->where('block_user_id', $receiver->id);
            })->orWhere(function($qry) use($receiver, $sender){
                $qry->where("user_id", $receiver->id)->where('block_user_id', $sender->id);
            });
        })->first();
    }

    /**
     * Check User has been Send Connection Request ot Not
     */
    public function is_sent_connection_request($to_user_id){
        $form_user_id = Auth::user()->id ?? $to_user_id;
        if($form_user_id == $to_user_id){
            return false;
        }
        $con_rqst = ConnectionRequest::where("from_id", $form_user_id)->where("to_id", $to_user_id)->where("status", "sent")->first();
        if( !empty($con_rqst) ){
            return true;
        }
        return false;
    }

    /**
     * Check User has been Receive Connection Request ot Not
     */
    public function is_receive_connection_request($from_user_id){
        $to_user_id = Auth::user()->id ?? $from_user_id;
        if($to_user_id == $from_user_id){
            return false;
        }
        $con_rqst = ConnectionRequest::where("from_id", $from_user_id)->where("to_id", $to_user_id)->where("status", "sent")->first();
        if( !empty($con_rqst) ){
            return true;
        }
        return false;
    }

    /**
     * Get Last Message
     */
    public function getLastMessageData($user_id){
        $auth_user_id = Auth::user()->id ?? $user_id;
        if($auth_user_id == $user_id){
            return null;
        }
        return $this->getLatestChatMessage($auth_user_id, $user_id);
    }

    /**
     * get total Unseen Message
     */
    protected function getTotalUnseenMessage($user, $auth_user = ""){
        if(is_numeric($user)){
            $user = User::find($user);
        }
        if(is_numeric($auth_user)){
            $auth_user = User::find($auth_user);
        }

        if( empty($auth_user) ){
            $auth_user = Auth::user();
        }
        if( !isset($auth_user->id) || $auth_user->id == $user->id){
            return 0;
        }
        return ChatList::where("to_user_id", $auth_user->id)->where("from_user_id", $user->id)->where("is_seen", false)->count("id");
    }

    /**
     * Get Block User
     * @param Users Model
     */
    protected function getBlockUserData($user){
        $auth_user = Auth::user();
        if( !isset($auth_user->id) || $auth_user->id == $user->id){
            return null;
        }
        $data = $this->getBlockData($auth_user, $user);
        return $data->user_id ?? null;
    }

    /**
     * Get User Block Status
     * @param Users Model
     */
    protected function getBlockStatus($user){
        $auth_user = Auth::user();
        if( !isset($auth_user->id) || $auth_user->id == $user->id){
            return false;
        }
        $block_user_data = $this->getBlockData($auth_user, $user);
        if( !empty($block_user_data) ){
            return true;
        }
        return false;
    }

     /**
     * Save Account Delete Info
     */
    public function addAccountDeleteInfo($user){
        $acc_delete_info = AccountDeleteInfo::where("user_id", $user->id)->first();
        if( empty($acc_delete_info) ){
            $acc_delete_info = new AccountDeleteInfo();
            $acc_delete_info->user_id = $user->id;
            $acc_delete_info->date = date('Y-m-d');
            $acc_delete_info->permanent_delete = false;
        }
        $acc_delete_info->save();
    }
}
