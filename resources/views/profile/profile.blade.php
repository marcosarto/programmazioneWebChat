@extends('layouts.app')
@section('content')
    <div class="container mt-4 mb-4 p-3 d-flex justify-content-center">
        <div class="card p-4">
            <div class=" image d-flex flex-column justify-content-center align-items-center"> <button class="btn btn-secondary"> <div class="chat-image">
                        {!! makeImageFromNameProfile($name) !!}
                    </div></button>
                <span class="name mt-3">{{ $name }}</span>
                @if($userId==\Illuminate\Support\Facades\Auth::id() or \Illuminate\Support\Facades\Auth::id()==1)
                    <div class=" d-flex mt-2"> <a href="{{url("/edit/{$userId}")}};" ><button class="btn1 btn-dark">Edit Profile</button></a>
                    </div>
                @endif
                @if(\Illuminate\Support\Facades\Auth::id()==1)
                    <div class=" d-flex mt-2"> <a href="{{url("/delete/{$userId}")}};" ><button class="btn1 btn-red">Delete Profile</button></a>
                    </div>
                @endif
                <div class="text mt-3"> <span> {{ $bio }} </span> </div>
                <div class=" px-2 rounded mt-4 date "> <span class="join">{{ $joined }}</span> </div>
            </div>
        </div>
    </div>
@endsection
<link rel="stylesheet" href=https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css>
