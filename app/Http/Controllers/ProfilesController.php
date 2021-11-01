<?php

namespace App\Http\Controllers;

use App\Models\MessageGroup;
use App\Models\Profile;
use App\Models\User;
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
        return view('profile.profile', $this->data);
    }

    public function edit_profile($userId)
    {
        $this->data['userId'] = $userId;
        $this->data['name'] = User::findOrFail($userId)->username;
        $profile = Profile::where('user_id',$userId)->get();
        foreach($profile as $p)
            $this->data['bio'] = $p->bio;
        return view('profile.edit', $this->data);
    }
}
