<?php

namespace App\Http\Components\Traits;

use App\Models\ChatList;
use App\Models\ChatListIndex;
use App\Models\UserPicture;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

trait ChatHelper{
    /**
     * get All Chat Messages with Pagination
     * @return User Chat Message
     */
    protected function getChatMessages($user, $another_user, $paginate = 15){
        
        return ChatList::where( function($qry){
            $qry->where("message", '!=', null)->orWhere("uploads", "!=", null)->orWhere("has_uploads", "!=", null);
        })
        ->where(function($qry)use($user, $another_user){
            $qry->where(function($qry)use($user, $another_user){
                $qry->where("from_user_id", $user->id)->where("to_user_id", $another_user->id)
                ->where(function($qry) use($user){
                    $qry->where("delete_from_sender", "!=", $user->id)->orWhere("delete_from_sender", null);
                });
            })
            ->orWhere(function($qry)use($user, $another_user){
                $qry->where("to_user_id", $user->id)->where("from_user_id", $another_user->id)
                ->where(function($qry) use($user){
                    $qry->where("delete_from_receiver", "!=", $user->id)->orWhere("delete_from_receiver", null);
                });
            });
        })->orderBy("id", "DESC")->paginate($paginate);
    }

    /**
     * Get All Chat Media
     */
    protected function getALLChatMedia($user, $another_user, $paginate = 15){
        return ChatList::where(function($qry)use($user, $another_user){
            $qry->where("from_user_id", $user->id)->where("to_user_id", $another_user->id)
            ->where(function($qry) use($user){
                $qry->where("delete_from_sender", "!=", $user->id)->orWhere("delete_from_sender", null);
            });;
        })->orWhere(function($qry)use($user, $another_user){
            $qry->where("to_user_id", $user->id)->where("from_user_id", $another_user->id)
            ->where(function($qry) use($user){
                $qry->where("delete_from_receiver", "!=", $user->id)->orWhere("delete_from_receiver", null);
            });
        })->where("uploads", "!=", null)->orderBy("id", "DESC")->paginate($paginate);
    }

    /**
     * get Latest Chat Message Data
     * @return Last Message
     */
    protected function getLatestChatMessage($user_id, $another_user_id){
        return ChatList::where(function($qry) use($user_id, $another_user_id){
            $qry->where("from_user_id", $user_id)->where("to_user_id", $another_user_id)
            ->where(function($qry) use($user_id){
                $qry->where("delete_from_sender", null)->orWhere("delete_from_sender", "!=", $user_id);
            });
        })->orWhere(function($qry) use($user_id, $another_user_id){
            $qry->where("from_user_id", $another_user_id)->where("to_user_id", $user_id)            
            ->where(function($qry) use($user_id){
                $qry->where("delete_from_receiver", null)->orWhere("delete_from_receiver", "!=", $user_id);
            });
        })->orderBy("id", "DESC")->first();
    }

    Protected function getSmgConnUserList($user_id, $except_user_id_arr = []){
        $arr1 = ChatList::where("from_user_id", $user_id)->whereNotIn("to_user_id", $except_user_id_arr)->select("to_user_id as user_id")->groupBy("user_id")->get()->pluck("user_id")->toArray();
        $arr2 = ChatList::where("to_user_id", $user_id)->whereNotIn("from_user_id", $except_user_id_arr)->select("from_user_id as user_id")->groupBy("user_id")->get()->pluck("user_id")->toArray();
        return array_unique(array_merge($arr1, $arr2));
    }
    
    /**
     * Delete All Chat messages
     * @param Two User ID
     * from_user_id => Sender
     * to_user_id => Receiver
     */
    protected function deleteAllMessages($user_id, $another_user_id){        
        $message_list =  ChatList::where(function($qry)use($user_id, $another_user_id){
            $qry->where("from_user_id", $user_id)->where("to_user_id", $another_user_id)   
            ->where(function($qry){
                $qry->where("delete_from_sender", null)->orWhere("delete_from_receiver", null);
            });

        })->orWhere(function($qry)use($user_id, $another_user_id){
            $qry->where("to_user_id", $user_id)->where("from_user_id", $another_user_id)
            ->where(function($qry){
                $qry->where("delete_from_sender", null)->orWhere("delete_from_receiver", null);
            });
        })->get();
        
        foreach($message_list as $message){
            
            if($message->from_user_id == $user_id){
                $message->delete_from_sender = $user_id;
            }else{
                $message->delete_from_receiver = $user_id;
            }
            $message->save();
        }
    }

    /**
     * Delete Singel messages
     */
    protected function deleteMessage($user_id, $another_user_id, $message_id){        
        $message_list =  ChatList::where(function($qry)use($user_id, $another_user_id){
            $qry->where("from_user_id", $user_id)->where("to_user_id", $another_user_id)
            ->where("delete_from_sender", "!=", $user_id);

        })->orWhere(function($qry)use($user_id, $another_user_id){
            $qry->where("to_user_id", $user_id)->where("from_user_id", $another_user_id)
            ->where(function($qry) use($user_id){
                $qry->where("delete_from_receiver", null)->orWhere("delete_from_receiver", "!=", $user_id);
            });
        })->where('id', $message_id)->get();
        if(count($message_list) == 0){
            throw new Exception(Lang::get("message.no_record_found"), 400);
        }
        foreach($message_list as $message){
            if($message->from_user_id == Auth::user()->id){
                $message->delete_from_sender = Auth::user()->id;
            }else{
                $message->delete_from_receiver = Auth::user()->id;
            }
        }
        $message->save();
    }

    /**
     * Add Chat Message Time For Users
     */
    public function trackMessageTime($user1_id, $user2_id){
        $chat_list_index1 = ChatListIndex::where("user_id", $user1_id)->where("another_user_id", $user2_id)->first();
        if( empty($chat_list_index1) ){
            $chat_list_index1 = new ChatListIndex();
        }
        $chat_list_index1->user_id = $user1_id;
        $chat_list_index1->another_user_id = $user2_id;
        $chat_list_index1->last_message_time = now();
        $chat_list_index1->save();

        $chat_list_index2 = ChatListIndex::where("user_id", $user2_id)->where("another_user_id", $user1_id)->first();
        if( empty($chat_list_index2) ){
            $chat_list_index2 = new ChatListIndex();
        }
        $chat_list_index2->user_id = $user2_id;
        $chat_list_index2->another_user_id = $user1_id;
        $chat_list_index2->last_message_time = now();
        $chat_list_index2->save();
    }

    

}