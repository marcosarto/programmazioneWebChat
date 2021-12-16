<?php

namespace App\Http\Controllers;

use App\Models\MessageGroup;
use App\Models\MessageGroupMember;
use App\Models\Profile;
use App\Models\User;
use App\Models\UserMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilesController extends Controller
{
    public function profile($userId)
    {
        $this->data['userId'] = $userId;
        $this->data['name'] = User::findOrFail($userId)->username;
        $profile = Profile::where('user_id',$userId)->get();
        foreach($profile as $p)
            $this->data['bio'] = $p->bio;


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

        return view('profile.profileTest', $this->data);
    }

    public function myprofile($userId)
    {
        $this->data['userId'] = $userId;
        $this->data['name'] = User::findOrFail($userId)->username;
        $profile = Profile::where('user_id',$userId)->get();
        foreach($profile as $p)
            $this->data['bio'] = $p->bio;


        $users = User::where('id', '!=', Auth::id())->get();
        $friendInfo = User::findOrFail($userId);
        $myInfo = User::find(Auth::id());
        $groupsAll = MessageGroup::get();
        $groups = array();
        $membersAll = MessageGroupMember::all();
        $members = array();

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


        return view('profile.profile', $this->data);
    }

    public function edit($userId)
    {
        $this->data['userId'] = $userId;
        $this->data['name'] = User::findOrFail($userId)->username;
        $profile = Profile::where('user_id',$userId)->get();
        foreach($profile as $p) {
            $this->data['bio'] = $p->bio;
            $this->data['id'] = $p->id;
        }

        return view('profile.edit', $this->data);
    }

    public function delete($id){
        $data = User::find($id);
        $data->delete();
        return redirect('home');
    }

    public function update(Request $req){
        $data = Profile::find($req->id);
        $data->bio = $req->bio;
        $data->save();
        if($data->user_id==Auth::id())
            return redirect('/home');
        return redirect('profile/'.$data->user_id);
    }
}
