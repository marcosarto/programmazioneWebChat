@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="users">
                <h5>Users</h5>
                <ul class="list-group list-chat-item">
                    @if($users->count())
                        @foreach($users as $user)
                            <li class="chat-user-list">
                                <a href="">
                                    <div class="chat-image">
                                        {!! makeImageFromName($user->username) !!}
                                    </div>
                                    <div class="chat-name">
                                        {{ $user->username }}
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
        <div class="col-md-9">
            <h1>
                Sezione messaggi
            </h1>
            Seleziona la conversazione!
        </div>
    </div>
@endsection
