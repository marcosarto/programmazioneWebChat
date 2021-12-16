<?php

namespace App\Http\Controllers;

use App\Models\MessageGroup;
use App\Models\MessageGroupMember;
use App\Models\UserMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->get();
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

        $this->data['notRead']= $notRead;
        $this->data['users'] = $users;
        $this->data['myInfo'] = $myInfo;
        $this->data['users'] = $users;
        $this->data['groups'] = $groups;
        return view('home', $this->data);
    }
}
