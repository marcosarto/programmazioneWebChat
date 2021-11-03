@extends('layouts.app')
@section('content')
    <div class="container mt-4 mb-4 p-3 d-flex justify-content-center">
        <div class="card p-4">
            <div class=" image d-flex flex-column justify-content-center align-items-center"> <button class="btn btn-secondary"> <div class="chat-image">
                        {!! makeImageFromNameProfile($name) !!}
                    </div></button>
                <span class="name mt-3">{{ $name }}</span>
                <div class="d-flex flex-row justify-content-center align-items-center mt-3"> <span class="number">1069 <span class="follow">Followers</span></span> </div>
                @if($userId==\Illuminate\Support\Facades\Auth::id() or \Illuminate\Support\Facades\Auth::id()==1)
                    <div class=" d-flex mt-2"> <a href="{{url("/edit/{$userId}")}};" ><button class="btn1 btn-dark">Edit Profile</button></a>
                    </div>
                @endif
                @if(\Illuminate\Support\Facades\Auth::id()==1)
                    <div class=" d-flex mt-2"> <a href="{{url("/delete/{$userId}")}};" ><button class="btn1 btn-red">Delete Profile</button></a>
                    </div>
                @endif
                <div class="text mt-3"> <span> {{ $bio }} </span> </div>
                <div class="gap-3 mt-3 icons d-flex flex-row justify-content-center align-items-center"> <span><i class="fa fa-twitter"></i></span> <span><i class="fa fa-facebook-f"></i></span> <span><i class="fa fa-instagram"></i></span> <span><i class="fa fa-linkedin"></i></span> </div>
                <div class=" px-2 rounded mt-4 date "> <span class="join">Joined May,2021</span> </div>
            </div>
        </div>
    </div>
@endsection
<link rel="stylesheet" href=https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css>
