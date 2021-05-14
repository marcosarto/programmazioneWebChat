@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="users">
                <h5>Users</h5>
                <ul class="list-group list-chat-item">
                    @if($users->count())
                        @foreach($users as $user)
                            <li class="chat-user-list @if($user->id == $friendInfo->id) active @endif">
                                <a href="">
                                    <div class="chat-image">
                                        {!! makeImageFromName($user->username) !!}
                                        <i class="fa fa-circle user-status-icon" title="away">

                                        </i>
                                    </div>
                                    <div class="chat-name font-weight-bold">
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
            Corpo conversazione
        </div>
    </div>
@endsection
