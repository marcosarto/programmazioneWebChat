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

        <div class="col-md-6 chat-section">
            <div class="chat-header">
                <div class="chat-image">
                    {!! makeImageFromName($friendInfo->username) !!}
                </div>

                <a href="{{ route('profile.show', $friendInfo->id) }}"><div class="chat-name font-weight-bold">
                        {{ $friendInfo->username }}
                    </div></a>
            </div>

            <div class="chat-body" id="chatBody">
                <div class="message-listing" id="messageWrapper">

                </div>
            </div>

            <div class="chat-box">
                <div class="chat-input bg-white" id="chatInput" contenteditable="">

                </div>

                <div class="chat-input-toolbar">
                    <button title="Add File" class="btn btn-light btn-sm btn-file-upload">
                        <i class="fa fa-paperclip"></i>
                    </button> |

                    <button title="Bold" class="btn btn-light btn-sm tool-items"
                            onclick="document.execCommand('bold', false, '');">
                        <i class="fa fa-bold tool-icon"></i>
                    </button>

                    <button title="Italic" class="btn btn-light btn-sm tool-items"
                            onclick="document.execCommand('italic', false, '');">
                        <i class="fa fa-italic tool-icon"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-3">
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
{{--                        <button type="submit" class="btn btn-primary">Save changes</button>--}}
{{--                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
{{--                    </div>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" />
<link rel="stylesheet" href=https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css>
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous"></script>
    <script>
        $(function (){
            let $chatInput = $(".chat-input");
            let $chatInputToolbar = $(".chat-input-toolbar");
            let $chatBody = $(".chat-body");
            let $messageWrapper = $("#messageWrapper");


            let user_id = "{{ auth()->user()->id }}";
            let ip_address = '127.0.0.1';
            let socket_port = '8005';
            let socket = io(ip_address + ':' + socket_port);
            let friendId = "{{ $friendInfo->id }}";
            var msgs = <?php
                echo \App\Models\UserMessage::all();?>;
            var texts = <?php
                echo \App\Models\Message::all();?>;

            for(const m of msgs){
                if(m['sender_id']==user_id && m['receiver_id']==friendId){
                    for(const t of texts){
                        if(t['id']==m['message_id'])
                            appendMessageToSender(t['message']);
                    }
                }
                if(m['sender_id']==friendId && m['receiver_id']==user_id){
                    for(const t of texts){
                        if(t['id']==m['message_id'])
                            appendMessageToReceiver(t['message']);
                    }
                }
            }

            socket.on('connect', function() {
                socket.emit('user_connected', user_id);
            });

            socket.on('updateUserStatus', (data) => {
                let $userStatusIcon = $('.user-status-icon');
                $userStatusIcon.removeClass('text-success');
                $userStatusIcon.attr('title', 'Away');

                $.each(data, function (key, val) {
                    if (val !== null && val !== 0) {
                        let $userIcon = $(".user-icon-"+key);
                        $userIcon.addClass('text-success');
                        $userIcon.attr('title','Online');
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

                let userInfo = '<div class="col-md-12 user-info">\n' +
                    '<div class="chat-image">\n' + image +
                    '</div>\n' +
                    '\n' +
                    '<div class="chat-name font-weight-bold">\n' +
                    name +
                    '<span class="small time text-gray-500" title="'+getCurrentDateTime()+'">\n' +
                    getCurrentTime()+'</span>\n' +
                    '</div>\n' +
                    '</div>\n';

                let messageContent = '<div class="col-md-12 message-content">\n' +
                    '                            <div class="message-text">\n' + message +
                    '                            </div>\n' +
                    '                        </div>';


                let newMessage = '<div class="row message align-items-center mb-2">'
                    +userInfo + messageContent +
                    '</div>';

                $messageWrapper.append(newMessage);
            }

            function appendMessageToReceiver(message) {
                let name = '{{ $friendInfo->username }}';
                let image = '{!! makeImageFromName($friendInfo->username) !!}';

                let userInfo = '<div class="col-md-12 user-info">\n' +
                    '<div class="chat-image">\n' + image +
                    '</div>\n' +
                    '\n' +
                    '<div class="chat-name font-weight-bold">\n' +
                    name +
                    '<span class="small time text-gray-500" title="'+dateFormat(message.created_at)+'">\n' +
                    timeFormat(message.created_at)+'</span>\n' +
                    '</div>\n' +
                    '</div>\n';

                let messageContent = '<div class="col-md-12 message-content">\n' +
                    '                            <div class="message-text">\n' + message.content +
                    '                            </div>\n' +
                    '                        </div>';


                let newMessage = '<div class="row message align-items-center mb-2">'
                    +userInfo + messageContent +
                    '</div>';

                $messageWrapper.append(newMessage);
            }

            socket.on("private-channel:App\\Events\\PrivateMessageEvent", function (message)
            {
                appendMessageToReceiver(message);
            });

            let $addGroupModal = $("#addGroupModal");
            $(document).on("click", ".btn-add-group", function (){
                $addGroupModal.modal();
            });

            $("#selectMember").select2();
        });
    </script>
@endpush
