<?php

namespace App\Http\Components\Traits;

use App\Http\FCM\ConnectionNotification;
use App\Http\FCM\PostActivityNotification;
use App\Models\Notification;
use App\Models\NotificationSettings;
use Exception;
use Illuminate\Support\Facades\Lang;

trait NotificationHelper{
    /**
     * Add / Store Connection Notification Data
     */
    public function addConnectionNotification($user, $connection_request, $notification_message){
        $notification = new Notification();
        $notification->user_id  = $user->id;
        $notification->connect_user_id = $connection_request->from_id;
        $notification->notification = $notification_message;
        $notification->connection_request = true;
        $notification->connection_request_id = $connection_request->id;
        $notification->save();

        try{
            $params = [
                "body"  => $notification_message,
                "data"  => [
                    "action"            => "connection_request_list",
                    "notification_id"   => $notification->id,
                ],
            ];
            if($this->checkNotificationSendPermission($user, "connection_notification")){
                return (new ConnectionNotification($params))->push($user);
            }
        }catch(Exception $e){
            // dd($e->getMessage().' on '. $e->getFile().':'.$e->getline());
        }
    }

    /**
     * Add / Store Connection Notification Data
     */
    public function connectionAcceptNotification($user, $connect_user_id, $notification_message){
        $notification = new Notification();
        $notification->user_id  = $user->id;
        $notification->connect_user_id = $connect_user_id;
        $notification->notification = $notification_message;
        $notification->save();

        try{
            $params = [
                "body"  => $notification_message,
                "data"  => [
                    "action"        => "profile_page",
                    "notification_id"=> $notification->id,
                ]
            ];
            if($this->checkNotificationSendPermission($user, "connection_notification")){
                return (new ConnectionNotification($params))->push($user);
            }
        }catch(Exception $e){
            // dd($e->getMessage().' on '. $e->getFile().':'.$e->getline());
        }
    }

    /**
     * Post Like Notification
     */
    public function sendPostNotification($user, $connect_user_id, $post, $notification_message, $type = "like"){
        
        if($user->id == $connect_user_id){
            return "";
        }
        $notification = new Notification();
        $notification->user_id  = $user->id;
        $notification->connect_user_id = $connect_user_id;
        $notification->post_id  = $post->id;
        $notification->notification = $notification_message;
        if($type == "like"){
            $notification->like = true;
        }else{
            $notification->comment = true;
        }
        $notification->save();

        try{
            $params = [
                "body"  => $notification_message,
                "data"  => [
                    "action"        => $type == "like" ? "post_like" : "post_comment",
                    "post_id"       => $post->id,
                    "notification_id"=> $notification->id,
                ]
            ];
            if($this->checkNotificationSendPermission($user, $type == "like" ? "like_notification" : "comment_notification")){
                return (new PostActivityNotification($params))->push($user);
            }
        }catch(Exception $e){
            // dd($e->getMessage().' on '. $e->getFile().':'.$e->getline());
        }
    }

    /**
     * Post Like Notification
     * @param User $user
     */
    public function sendChatNotification($user, $chat_message, $notification_message){
        if($this->checkNotificationSendPermission($user, "message_notification")){
            try{
                
                $params = [
                    "body"  => $notification_message,
                    "data"  => [
                        "action"        => "chat_page",
                        "chat_id"       => $chat_message->id,
                    ]
                ];
                return (new ConnectionNotification($params))->push($user);
            }catch(Exception $e){
                
            }
        }
    }

    /**
     * Check Send Notification is Allow or Not
     * @return boolean;
     */
    protected function checkNotificationSendPermission($user, $permission = "default"){
        $settings = $this->getNotificationSettings($user);
        if( empty($settings) ){
            return true;
        }
        switch($permission){
            case 'connection_notification':
                return $settings->connection_notification;
                break;
            case 'post_notification':
                return $settings->post_notification;
                break;
            case 'like_notification':
                return $settings->like_notification;
                break;
            case 'comment_notification':
                return $settings->comment_notification;
                break;
            case 'message_notification':
                return $settings->message_notification;
                break;
            case 'group_message_notification':
                return $settings->group_message_notification;
                break;
            case 'others_notification':
                return $settings->others_notification;
                break;
            case 'default':
                return true;
                break;
        }
    }

    /**
     * Get Notification Settings
     */
    protected function getNotificationSettings($user){
        return NotificationSettings::where("user_id", $user->id)->first();
    }
}