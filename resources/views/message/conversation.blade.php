@extends('layouts.app')

<style>
    .select2-container {
        width: 100% !important;
    }
</style>
@section('content')
    <div class="row chat-row">
        <?php $text = 'Insert message here'; ?>
        <div class="col-md-3 scrollable">
            <div class="users">
                <h4 style="text-align: center">Users</h4>
                <br>
                <ul class="list-group list-chat-item">
                    @if($users->count())
                        @foreach($users as $user)
                            <li class="chat-user-list
                                @if($user->id == $friendInfo->id) active @endif">
                                <a href="{{ route('message.conversation', $user->id) }}">
                                    <div class="chat-image">
                                        {!! makeImageFromName($user->username) !!}
                                        <i class="fa fa-circle user-status-icon user-icon-{{ $user->id }}"
                                           title="away"></i>
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

        <div class="col-md-9 chat-section">
            <div class="chat-header">
                <div class="chat-image">
                    {!! makeImageFromName($friendInfo->username) !!}
                </div>

                <div class="chat-name font-weight-bold">
                    <a href="{{ route('profile.show', $friendInfo->id) }}">{{ $friendInfo->username }}</a>
                    {{--                    <i class="fa fa-circle user-status-head" title="away"--}}
                    {{--                       id="userStatusHead{{$friendInfo->id}}"></i>--}}
                </div>
            </div>

            <div class="chat-body" id="chatBody">
                <div class="message-listing" id="messageWrapper">

                </div>
            </div>

            <div class="chat-box">
                <div class="chat-input bg-white" id="chatInput" contenteditable="" onclick="remove(this)">
                    Insert message
                </div>

                <div class="chat-input-toolbar">
                    <button title="Add File" class="btn btn-light btn-sm btn-file-upload">
                        <i class="fa fa-paperclip"></i>
                    </button>
                    |

                    <button title="Bold" class="btn btn-light btn-sm tool-items"
                            onclick="document.execCommand('bold', false, '');">
                        <i class="fa fa-bold tool-icon"></i>
                    </button>

                    <button title="Italic" class="btn btn-light btn-sm tool-items"
                            onclick="document.execCommand('italic', false, '');">
                        <i class="fa fa-italic tool-icon"></i>
                    </button>

                    <button class="btn btn-light btn-sm sendWithButton border-dark float-right" onclick="this.blur();">
                        &#8626;
                    </button>

                </div>
            </div>
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
        function remove(el) {
            var t = el.textContent;
            var element = el;
            if (t.includes("Insert message"))
                element.innerHTML = '';
        }

        $(function () {
            let $chatInput = $(".chat-input");
            let $chatInputToolbar = $(".chat-input-toolbar");
            let $chatBody = $(".chat-body");
            let $messageWrapper = $("#messageWrapper");
            var lastMsg = -1;

            let user_id = "{{ auth()->user()->id }}";
            let ip_address = '127.0.0.1';
            let socket_port = '8005';
            let socket = io(ip_address + ':' + socket_port);
            let friendId = "{{ $friendInfo->id }}";
            var msgs = <?php
                echo \App\Models\UserMessage::all();?>;
            var texts = <?php
                echo \App\Models\Message::all();?>;

            for (const m of msgs) {
                if (m['sender_id'] == user_id && m['receiver_id'] == friendId) {
                    for (const t of texts) {
                        if (t['id'] == m['message_id'])
                            appendMessageToSender(t);
                    }
                }
                if (m['sender_id'] == friendId && m['receiver_id'] == user_id) {

                    if (m['seen_status'] == 0) {
                        let url = "{{ route('message.read-message') }}";
                        let form = $(this);
                        let formData = new FormData();
                        let token = "{{ csrf_token() }}";

                        formData.append('messageId', m.message_id);
                        formData.append('_token', token);
                        //formData.append('receiver_id', friendId);
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            dataType: 'JSON',
                            success: function (response) {
                                location.reload();
                            }
                        });
                    }

                    for (const t of texts) {
                        if (t['id'] == m['message_id'])
                            appendMessageToReceiver(t);
                    }
                }
            }

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


            $chatInput.keypress(function (e) {
                let message = $(this).html();
                if (e.which === 13 && !e.shiftKey) {
                    $chatInput.html("");
                    sendMessage(message);
                    return false;
                }
            });

            function sendMessage(message) {
                let url = "{{ route('message.send-message') }}";
                let form = $(this);
                let formData = new FormData();
                let token = "{{ csrf_token() }}";

                formData.append('message', message);
                formData.append('_token', token);
                formData.append('receiver_id', friendId);

                appendMessageToSender(message);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    success: function (response) {
                        if (response.success) {
                            console.log(response.data);
                        }
                    }
                });
            }

            function appendMessageToSender(message) {
                let name = '{{ $myInfo->username }}';
                let image = '{!! makeImageFromName($myInfo->username) !!}';

                let testo;
                let data;
                let time;
                if (typeof message.created_at === "undefined") {
                    data = getCurrentDateTime();
                    time = getCurrentTime();
                } else {
                    data = dateFormat(message.created_at);
                    time = timeFormat(message.created_at);
                }

                let userInfo = '<div class="col-md-12 user-info">\n' +
                    '<div class="chat-image">\n' + image +
                    '</div>\n' +
                    '\n' +
                    '<div class="chat-name font-weight-bold">\n' +
                    name +
                    '<span class="small time text-gray-500" title="' + data + '">\n' +
                    time + '</span>\n' +
                    '</div>\n' +
                    '</div>\n';

                if (typeof message.message === "undefined") {
                    testo = message;
                } else {
                    testo = message.message;
                }

                let messageContent = '<div class="col-md-12 message-content">\n' +
                    '                            <div class="message-text">\n' + testo +
                    '                            </div>\n' +
                    '                        </div>';


                let newMessage = '<div class="row message mb-2">'
                    + userInfo + messageContent +
                    '</div>';
                let newMessageAppended = '<div class="row message mb-2">'
                    + messageContent +
                    '</div>';
                if (lastMsg === -1 || lastMsg === 1)
                    $messageWrapper.append(newMessage);
                else
                    $messageWrapper.append(newMessageAppended);
                lastMsg = 0;
            }

            function appendMessageToReceiver(message) {
                let name = '{{ $friendInfo->username }}';
                let image = '{!! makeImageFromName($friendInfo->username) !!}';
                let testo;

                let userInfo = '<div class="col-md-12 user-info">\n' +
                    '<div class="chat-image">\n' + image +
                    '</div>\n' +
                    '\n' +
                    '<div class="chat-name font-weight-bold">\n' +
                    name +
                    '<span class="small time text-gray-500" title="' + dateFormat(message.created_at) + '">\n' +
                    timeFormat(message.created_at) + '</span>\n' +
                    '</div>\n' +
                    '</div>\n';

                if (typeof message.message === "undefined") {
                    testo = message;
                } else {
                    testo = message.message;
                }

                let messageContent = '<div class="col-md-12 message-content">\n' +
                    '                            <div class="message-text">\n' + testo +
                    '                            </div>\n' +
                    '                        </div>';


                let newMessage = '<div class="row message align-items-center mb-2">'
                    + userInfo + messageContent +
                    '</div>';

                let newMessageAppended = '<div class="row message align-items-center mb-2">'
                    + messageContent +
                    '</div>';

                if (lastMsg === -1 || lastMsg === 0)
                    $messageWrapper.append(newMessage);
                else
                    $messageWrapper.append(newMessageAppended);
                lastMsg = 1;
            }

            socket.on("private-channel:App\\Events\\PrivateMessageEvent", function (message) {
                if (friendId == message.sender_id) {
                    let url = "{{ route('message.read-message') }}";
                    let form = $(this);
                    let formData = new FormData();
                    let token = "{{ csrf_token() }}";

                    formData.append('messageId', message.message_id);
                    formData.append('_token', token);
                    //formData.append('receiver_id', friendId);
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: 'JSON',
                        success: function (response) {
                        }
                    });
                    appendMessageToReceiver(message);
                } else {
                    location.reload();
                }
            });

            $(document).on("click", ".sendWithButton", function () {
                el = document.getElementById("chatInput");
                message = el.textContent;
                sendMessage(message);
                el.innerHTML='';
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
