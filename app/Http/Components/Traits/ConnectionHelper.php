<?php

namespace App\Http\Components\Traits;

use App\Models\ConnectionRequest;
use App\Models\User;
use App\Models\UserConnection;

trait ConnectionHelper{
    /**
     * Connected User List
     */
    protected function getConnectedUserList($user){
        $list1 = UserConnection::whereHas("connectedUser", function($qry){
            $qry->where("status", "active");
        })->where("user_id", $user->id)->select("connected_user_id as user_id")->pluck('user_id')->toArray();
        $list2 = UserConnection::whereHas("user", function($qry){
            $qry->where("status", "active");
        })->where("connected_user_id", $user->id)->select("user_id as user_id")->pluck('user_id')->toArray();
        return array_unique(array_merge($list1, $list2));
    }

    /**
     * Connection Request Send User List
     *  @return Array List
     */
    protected function getRequestConnectionUserList($user, $hide_receive_request = false){
        $list1 = $this->getSendRequestUserIdList($user);
        if(!$hide_receive_request){
            $list2 = $this->getReceiveRequestUserIdList($user);
            return array_unique(array_merge($list1, $list2));
        }
        return $list1;
    }

    /**
     * Get Receive Connection User ID List
     * @return Array List
     */
    protected function getReceiveRequestUserIdList($user){
        return ConnectionRequest::where("to_id", $user->id)->select("from_id as user_id")->where("status", "sent")->pluck('user_id')->toArray();
    }

    /**
     * get Send Connetion Request User ID List
     *  @return Array List
     */
    protected function getSendRequestUserIdList($user){
        return ConnectionRequest::where("status", "=", "sent")->where("from_id", $user->id)->select("to_id as user_id")->groupBy("user_id")->pluck('user_id')->toArray();
    }

    /**
     * Check User is Connected or Not
     * if Connected Then @return true else false
     */
    protected function checkUserConnection($to_user, $from_user){
        $data = UserConnection::where(function($qry) use($to_user, $from_user){
            $qry->where("user_id", $to_user)->where("connected_user_id", $from_user);
        })
        ->orWhere(function($qry) use($to_user, $from_user){
            $qry->where("user_id", $from_user)->where("connected_user_id", $to_user);
        })->first();
        if( empty($data) ){
            return false;
        }
        return true;
    }

    /**
     * Check Connection Exists
     * if Exicts Then Retuen The Request Data
     * @return ConnectionRequest Or False
     */
    public function getConnectionRequestData($from_user, $to_user){
        $data = ConnectionRequest::where(function($qry) use($from_user, $to_user){
            $qry->where("from_id", $from_user->id )->where('to_id', $to_user->id);
        })->orWhere(function($qry) use($from_user, $to_user){
            $qry->where("to_id", $from_user->id )->where('from_id', $to_user->id);
        })->orderBy("id", "DESC")->first();
        if( !empty($data) ){
            return $data;
        }
        return false;
    }

    /**
     * Send Request to User
     */
    protected function connectionRequest($from_user_id, $to_user_id, $status = "sent"){
        $con_request = new ConnectionRequest();
        $con_request->from_id   = $from_user_id;
        $con_request->to_id     = $to_user_id;
        $con_request->status   = $status;
        $con_request->sent_at = now();        
        $con_request->save();
        return $con_request;
    }

    /**
     * Add Or Update Connection Request Data
     */
    protected function updateConnectionRequest($con_req, $status = "accepted"){
        $con_req->status = $status;
        if($status == "accepted"){
            $con_req->accepted_at = now();
        }
        if($status == "rejected"){
            $con_req->rejected_at = now();
        }
        $con_req->save();
        return $con_req;
    }

    /**
     * Connected Estublished Between Two User
     * @return Connected Data In new connection
     */
    protected function addConnectinBetweenUser($to_user, $from_id, $type = "add"){
        if( $type != "add" ){
            UserConnection::where(function($qry) use($to_user, $from_id){
                $qry->where("user_id", $to_user)->where("connected_user_id", $from_id);
            })
            ->orWhere(function($qry) use($to_user, $from_id){
                $qry->where("user_id", $from_id)->where("connected_user_id", $to_user);
            })
            ->delete();
            return true;
        }
        $data = new UserConnection();
        $data->user_id = $to_user;
        $data->connected_user_id = $from_id;
        $data->save();
        return $data;
    }

    
}