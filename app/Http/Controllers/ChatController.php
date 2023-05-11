<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\Message;
use App\Models\ChatRoom;
use App\Models\User;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;
use App\Events\NewChatMessage;

class ChatController extends Controller
{
    public function getUserId(Request $request)
    {
        return Auth::user()->id;
    }

    public function getAllUser(Request $request)
    {
        return  User::all();
    }

    public function checkRooms(Request $request)
    {
        $getRoom1 = ChatRoom::where('user1_id', Auth::user()->id)->get();
        $getRoom2 = ChatRoom::where('user2_id', Auth::user()->id)->get();
        
 
        $concatenated = $getRoom1->concat( $getRoom2);
         
        $concatenated->all();
        return $concatenated->all();
    }

    public function rooms(Request $request)
    {
        $users = User::all();
        $getRoom1 = ChatRoom::where('user1_id', Auth::user()->id)->get();
        foreach($getRoom1 as $key1 => $getR1){
            foreach($users as $key2 => $user){
                if($getR1->user2_id == $user->id){
                    $getRoom1[$key1]->address =  $user->address;
                }
            };
        };
        $getRoom2 = ChatRoom::where('user2_id', Auth::user()->id)->get();
        
        foreach($getRoom2 as $key1 => $getR2){
            foreach($users as $key2 => $user){
                if($getR2->user1_id == $user->id){
                    $getRoom2[$key1]->address =  $user->address;
                }
            };
        };
        $concatenated = $getRoom1->concat( $getRoom2);
         
        $concatenated->all();
        return $concatenated->all();
    }
    
    public function messages(Request $request, $roomId) 
    {
        // return $roomId;
        return ChatMessage::where('chat_room_id', $roomId)
            ->with('user')
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function newMessage (Request $request, $roomId)
    {
        $newMessage = new ChatMessage;
        $newMessage->user_id = Auth::id();
        $newMessage->chat_room_id = $roomId;
        $newMessage->message = $request->message;
        $newMessage->save();

        broadcast(new NewChatMessage( $newMessage ))->toOthers();

        return $newMessage;
    }

    public function chatNow(Request $request)
    {
        $chatRoom = ChatRoom::all();
        if(sizeof($chatRoom) == 0){
            $newRoom = new  ChatRoom;
            $newRoom->user1_id = Auth::user()->id;
            $newRoom->user2_id = $request->user_id;
            $newRoom->save();
            return $newRoom->id;
        } else {
            $findRoom1 = ChatRoom::where('user1_id', Auth::user()->id)->where('user2_id', $request->user_id)->get();
            if(sizeof($findRoom1) != 0){
                return $findRoom1[0]->id;
                
            } else {
                $findRoom2 = ChatRoom::where('user1_id', $request->user_id)->where('user2_id', Auth::user()->id)->get();
                if(sizeof($findRoom2) != 0){
                    return $findRoom2[0]->id;
                } else {
                    $newRoom = new  ChatRoom;
                    $newRoom->user1_id = Auth::user()->id;
                    $newRoom->user2_id = $request->user_id;
                    $newRoom->save();
                    return $newRoom->id;
                }
            }
        }

        
    }
}
