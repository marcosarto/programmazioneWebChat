@extends('layouts.app')

<style>
    .select2-container {
        width: 100% !important;
    }
</style>

@section('content')
    <div class="row chat-row">
        <div class="col-md-3 scrollable">
            <div class="users">
                <h4 style="text-align: center">Users</h4>
                <br>
                <ul class="list-group list-chat-item">
                    @if($users->count())
                        @foreach($users as $user)
                            <li class="chat-user-list">
                                <a href="{{route('message.conversation',$user->id)}}">
                                    <div class="chat-image">
                                        {!! makeImageFromName($user->username) !!}
                                        <i class="fa fa-circle user-status-icon user-icon-{{ $user->id }}" title="away">

                                        </i>
                                    </div>
                                    <div class="chat-name font-weight-bold">
                                        {{ $user->username }} ({{ $notRead[$user->id] }})
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <br>
            <hr style="height:1px;border-width:0;color:black;background-color:black">
{{--            <div class="groups mt-5">--}}
{{--                <h4 style="text-align: center">Groups<i class="fa fa-plus btn-add-group ml-3 text-danger"></i></h4>--}}
{{--                <br>--}}
{{--                <ul class="list-group list-chat-item">--}}
{{--                    @if(count($groups))--}}
{{--                        @foreach($groups as $group)--}}
{{--                            <li class="chat-user-list">--}}
{{--                                <a href="{{ route('message-groups.show', $group->id) }}">--}}
{{--                                    <div class="chat-image">--}}
{{--                                        {!! makeImageFromNameGroup($group->name) !!}--}}
{{--                                    </div>--}}

{{--                                    <div class="chat-name font-weight-bold">--}}
{{--                                        {{ $group->name }}--}}
{{--                                    </div>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        @endforeach--}}
{{--                    @endif--}}
{{--                </ul>--}}
{{--            </div>--}}
        </div>
        <div class="col-md-9">
            <h1>
                Message section
            </h1>
            <p class="lead">
                Select user from the list to begin conversation.
            </p>
        </div>
    </div>
{{--    <div class="modal" tabindex="-1" role="dialog" id="addGroupModal">--}}
{{--        <div class="modal-dialog modal-lg" role="document">--}}
{{--            <div class="modal-content">--}}
{{--                <div class="modal-header">--}}
{{--                    <h5 class="modal-title">Add Group</h5>--}}
{{--                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                        <span aria-hidden="true">&times;</span>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--                <form action="{{ route('message-groups.store') }}" method="post">--}}
{{--                    {{ csrf_field() }}--}}
{{--                    <div class="modal-body">--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="">Group Name</label>--}}
{{--                            <input type="text" class="form-control" name="name">--}}
{{--                        </div>--}}

{{--                        <div class="form-group">--}}
{{--                            <label for="">Select Member</label>--}}
{{--                            <select id="selectMember" class="form-control" name="user_id[]" id="" multiple="multiple">--}}
{{--                                @foreach($users as $user)--}}
{{--                                    <option value="{{ $user->id }}">--}}
{{--                                        {{ $user->username }}--}}
{{--                                    </option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="modal-footer">--}}
{{--                        <button type="submit" class="btn btn-primary">Create group</button>--}}
{{--                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
{{--                    </div>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
      integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
      crossorigin="anonymous"/>
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
            integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
            crossorigin="anonymous"></script>
    <script>
        $(function () {
            let user_id = "{{ auth()->user()->id }}";
            let ip_address = '127.0.0.1';
            let socket_port = '8005';
            let socket = io(ip_address + ':' + socket_port);

            socket.on('connect', function () {
                socket.emit('user_connected', user_id);
            });

            socket.on('updateUserStatus', (data) => {
                let $userStatusIcon = $('.user-status-icon');
                $userStatusIcon.removeClass('text-success');
                $userStatusIcon.attr('title', 'Away');

                $.each(data, function (key, val) {
                    if (val !== null && val !== 0) {
                        let $userIcon = $(".user-icon-" + key);
                        $userIcon.addClass('text-success');
                        $userIcon.attr('title', 'Online');
                    }
                });
            });
            socket.on("private-channel:App\\Events\\PrivateMessageEvent", function (message) {
                location.reload();
            });
            let $addGroupModal = $("#addGroupModal");
            $(document).on("click", ".btn-add-group", function () {
                console.log('ciao');
                $addGroupModal.modal();
            });

            $("#selectMember").select2();
        });
    </script>
@endpush
