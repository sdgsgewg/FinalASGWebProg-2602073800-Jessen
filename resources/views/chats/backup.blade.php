@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/chat/style.css') }}?v={{ time() }}">
@endsection

@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-11 col-lg-8">
            <div class="chat-box">
                {{-- Chat Header: Recipient Related Information --}}
                <div class="d-flex flex-row align-items-center mb-3">
                    <div class="col-1">
                        <a href="{{ route('chats.index') }}" class="color-inherit">
                            <i class="bi bi-arrow-left fs-3"></i>
                        </a>
                    </div>
                    <div class="col-10">
                        <h3 class="fw-bold m-0">{{ $recipient->name }}</h3>
                    </div>
                </div>

                <div class="chat-content" id="chat-messages">
                    @forelse ($chat->messages as $message)
                        @php
                            $isSender = auth()->user()->id === $message->sender->id;
                        @endphp
                        <div class="message {{ $isSender ? 'sent' : 'received' }} pb-2">
                            <div class="message-bubble">
                                <p class="m-0">{{ $message->message_text }}</p>
                            </div>
                            <div class="message-info {{ $isSender ? 'sent' : 'received' }}">
                                <span class="timestamp">
                                    {{ \Carbon\Carbon::parse($message->created_at)->timezone('Asia/Jakarta')->format('H:i') }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted">
                            {{ __('chat.no_messages_yet') }}
                        </p>
                    @endforelse
                </div>

                {{-- To store the chat message --}}
                <form id="chat-form" method="POST" action="{{ route('chats.store') }}" class="chat-form">
                    @csrf
                    <input type="hidden" name="chat" id="chat" value="{{ $chat->id }}">
                    <div class="input-group">
                        <input type="text" name="message" id="message-input" class="form-control"
                            placeholder="{{ __('chat.type_msg') }}" required>
                        <button type="submit" class="btn btn-primary send-btn">{{ __('chat.send') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

    <script>
        // Inisialisasi Pusher
        Pusher.logToConsole = true;

        var pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
            cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
            forceTLS: true
        });


        // Berlangganan ke saluran pribadi
        var channel = pusher.subscribe('chat.{{ $chat->id }}');

        // Mendengarkan peristiwa 'MessageSent' dan menambahkan pesan baru
        channel.bind('App\\Events\\MessageSent', function(data) {
            var message = data.message;
            var chatMessages = document.getElementById('chat-messages');
            var newMessage = document.createElement('div');
            var isSender = {{ auth()->user()->id }} === message.sender_id;
            newMessage.classList.add('message', isSender ? 'sent' : 'received', 'pb-2');
            newMessage.innerHTML = `
                <div class="message-bubble">
                    <p class="m-0">${message.message_text}</p>
                </div>
                <div class="message-info ${isSender ? 'sent' : 'received'}">
                    <span class="timestamp">
                        ${new Date(message.created_at).toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit' })}
                    </span>
                </div>
            `;
            chatMessages.appendChild(newMessage);
            chatMessages.scrollTop = chatMessages.scrollHeight; // Scroll otomatis ke bawah
        });
    </script>

    <script>
        document.getElementById('chat-form').addEventListener('submit', function(e) {
            e.preventDefault();

            var messageInput = document.getElementById('message-input');
            var message = messageInput.value.trim();

            if (message !== '') {
                axios.post('{{ route('chats.store') }}', {
                    chat: document.getElementById('chat').value,
                    message: message,
                    _token: '{{ csrf_token() }}'
                }).then(response => {
                    messageInput.value = ''; // Clear the input field after sending
                }).catch(error => {
                    console.error('Error sending message:', error);
                });
            }
        });
    </script>
@endsection
