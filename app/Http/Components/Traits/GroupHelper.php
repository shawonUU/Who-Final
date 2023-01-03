<?php

namespace App\Http\Components\Traits;

use App\Models\ChatListIndex;
use App\Models\GroupChat;
use App\Models\GroupMember;
use App\Models\GroupMessageSeen;
use App\Models\User;
use App\Models\UserGroup;
use Exception;
use Illuminate\Support\Facades\Auth;

trait GroupHelper{
    /**
     * get User connected Groups
     * @return GroupList Arr
     */
    protected function getConnectedGroups($user, $group_name = ""){
        $groups = UserGroup::join("group_members", "group_members.user_group_id", "=", "user_groups.id")
            ->where("group_members.user_id", $user->id);
        if( !empty($group_name) ){
            $groups->where('user_groups.name', "like", "%".$group_name."%");
        }
        $groups = $groups->groupBy("user_groups.id")->select("user_groups.*")->get();
        return $groups;
    }

    /**
     * Add Group Members
     */
    protected function addGroupMembers($group_id, $user_ids){
        if(!is_array($user_ids)){
            $user_ids = (array)$user_ids;
        }
        
        foreach($user_ids as $user_id){
            $user = User::find($user_id);
            if( empty($user) ){
                throw new Exception("User Not Found");
            }

            $data = GroupMember::where("user_group_id", $group_id)->where("user_id", $user_id)->first();
            if(!empty($data)){
                continue;
            }
            $data = new GroupMember();
            $data->user_group_id = $group_id;
            $data->user_id = $user_id;
            $data->save();
        }
    }

    /**
     * Get total Unreed Message
     */
    protected function getUnreadMessage($group_id, $auth_user = ""){
        if( empty($auth_user) ){            
            $auth_user = Auth::user();
        }
        if(empty($auth_user)){
            return 0;
        }
        $last_seen = GroupMessageSeen::where("group_id", $group_id)->where("user_id", $auth_user->id)->orderBy("id", "desc")->first();
        return GroupChat::where("group_id", $group_id)->where("id", ">", $last_seen->last_seen_message_id ?? 0)->count("id");
    }

    /**
     * member Based Grop Message Unseen Count
     */
    public function getTotalUnseenUserGroupMessage($user_id, $group_id){
        $last_seen = GroupMessageSeen::where("group_id", $group_id)->where("user_id", $user_id)->orderBy("id", "desc")->first();
        return GroupChat::where("group_id", $group_id)->where("id", ">", $last_seen->last_seen_message_id ?? 0)->count("id");
    }

    protected function isLeaveMember($group_id, $user_id){
        $member = GroupMember::where("user_group_id", $group_id)->where("user_id", $user_id)->first();
        if( !empty($member) ){
            return false;
        }
        return true;
    }

    /**
     * Syncronize Group Message Time
     */
    protected function syncGroupMessageTime($group_id){
        $group = UserGroup::find($group_id);
        $group_members = $group->members();
        foreach($group_members as $user){
            $chat_index = ChatListIndex::where("user_id", $user->id)->where("group_id", $group->id)->first();
            if( empty($chat_index) ){
                $chat_index = new ChatListIndex();
                $chat_index->user_id = $user->id;
                $chat_index->group_id = $group->id;
            }
            $chat_index->last_message_time = now();
            $chat_index->save();
        }
    }
}