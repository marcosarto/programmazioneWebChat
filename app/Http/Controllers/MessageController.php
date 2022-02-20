<?php

namespace App\Http\Controllers;

use App\Events\GroupMessageEvent;
use App\Models\Message;
use App\Models\MessageGroup;
use App\Models\MessageGroupMember;
use App\Models\User;
use App\Models\UserMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\PrivateMessageEvent;

class MessageController extends Controller
{
    public function conversation($userId) {
        $users = User::where('id', '!=', Auth::id())->get();
        $friendInfo = User::findOrFail($userId);
        $myInfo = User::find(Auth::id());
        $groupsAll = MessageGroup::get();
        $groups = array();
        $membersAll = MessageGroupMember::all();
        $members = array();
        $notRead = array();

        foreach ($users as $u){
            $n = UserMessage::where('receiver_id','=',Auth::id(),'and')->where('sender_id','=',$u->id)->where('seen_status','=',0)->get();
            $notRead[$u->id] = count($n);
        }

        foreach($membersAll as $m){
            if($m->user_id==Auth::id())
                array_push($members,$m);
        }

        foreach($groupsAll as $g){
            foreach($members as $m){
                if($g->id == $m->message_group_id)
                    array_push($groups,$g);
            }
            if ($g->user_id==Auth::id())
                array_push($groups,$g);
        }

        $this->data['users'] = $users;
        $this->data['friendInfo'] = $friendInfo;
        $this->data['myInfo'] = $myInfo;
        $this->data['users'] = $users;
        $this->data['groups'] = $groups;
        $this->data['notRead']= $notRead;

        return view('message.conversation', $this->data);
    }

    public function sendMessage(Request $request) {
        $request->validate([
            'message' => 'required',
            'receiver_id' => 'required'
        ]);

        $sender_id = Auth::id();
        $receiver_id = $request->receiver_id;

        $message = new Message();
        $message->message = $request->message;

        if ($message->save()) {
            try {
                $message->users()->attach($sender_id, ['receiver_id' => $receiver_id]);
                $sender = User::where('id', '=', $sender_id)->first();

                $data = [];
                $data['sender_id'] = $sender_id;
                $data['sender_name'] = $sender->name;
                $data['receiver_id'] = $receiver_id;
                $data['content'] = $message->message;
                $data['created_at'] = $message->created_at;
                $data['message_id'] = $message->id;

                event(new PrivateMessageEvent($data));

                return response()->json([
                    'data' => $data,
                    'success' => true,
                    'message' => 'Message sent successfully'
                ]);
            } catch (\Exception $e) {
                $message->delete();
            }
        }
    }

    public function sendGroupMessage(Request $request) {
        $request->validate([
            'message' => 'required',
            'message_group_id' => 'required'
        ]);

        $sender_id = Auth::id();
        $messageGroupId = $request->message_group_id;

        $message = new Message();
        $message->message = $request->message;

        if ($message->save()) {
            try {
                $message->users()->attach($sender_id, ['message_group_id' => $messageGroupId]);
                $sender = User::where('id', '=', $sender_id)->first();

                $data = [];
                $data['sender_id'] = $sender_id;
                $data['sender_name'] = $sender->name;
                $data['content'] = $message->message;
                $data['created_at'] = $message->created_at;
                $data['message_id'] = $message->id;
                $data['group_id'] = $messageGroupId;
                $data['type'] = 2;

                event(new GroupMessageEvent($data));

                return response()->json([
                    'data' => $data,
                    'success' => true,
                    'message' => 'Message sent successfully'
                ]);
            } catch (\Exception $e) {
                $message->delete();
            }
        }
    }

    public function readMessage(Request $request) {
//        $request->validate([
//            'message' => 'required',
//            'receiver_id' => 'required'
//        ]);

        $sender_id = Auth::id();
        $receiver_id = $request->receiver_id;

        $message = UserMessage::where('message_id','=',$request->messageId)->first();
        $message->seen_status=1;
        $myfile = fopen("testfile.txt", "w");
        fwrite($myfile, $message);
        $message->save();

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully'
        ]);
    }
}


