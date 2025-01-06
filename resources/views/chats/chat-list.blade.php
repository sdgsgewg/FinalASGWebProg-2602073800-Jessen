@extends('layouts.app')

@section('css')
    <style>
        .chat-card {
            transition: background-color 0.2s;
        }

        .chat-card:hover {
            cursor: pointer;
            background-color: #909090;
        }

        .chat-card .profile-img {
            width: 5.5rem;
            height: 5.5rem;
        }
    </style>
@endsection

@section('content')

    <div class="row justify-content-center mt-5">
        <div class="col-10">
            <h1 class="pb-2 border-bottom">{{ __('chat.title') }}</h1>
        </div>
    </div>

    <div class="row justify-content-center mt-2">
        <div class="col-10">

            @if ($chats->count() > 0)
                @foreach ($chats as $chat)
                    {{-- Determine the recipient --}}
                    @php
                        $recipient = $chat->recipient;
                    @endphp

                    <div class="card chat-card col-12 d-flex flex-row justify-content-between p-3 mb-3" style="height: 120px;"
                        onclick="event.stopPropagation(); 
                        window.location.href='{{ route('chats.show', ['chat' => $chat->id]) }}'">

                        {{-- Recipient Profile Picture --}}
                        <div class="col-8 col-lg-8 d-flex flex-row" style="height:100%;">
                            {{-- Recipient Image --}}
                            <div class="col-4 col-md-3 overflow-hidden">
                                <img src="{{ asset('img/' . $recipient->gender . '.png') }}" alt="{{ $recipient->name }}"
                                    class="rounded-circle object-cover profile-img">
                            </div>
                            {{-- Recipient Name --}}
                            <div class="col-8 col-md-9 d-flex flex-column justify-content-between">
                                <h5 class="fw-bold">{{ $recipient->name }}</h5>
                                <div>
                                    @php
                                        $latestMessage = $chat->latestMessage;
                                    @endphp
                                    <p class="text-start">
                                        {{ $latestMessage ? $latestMessage->message_text : __('chat.no_messages') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Chat Information --}}
                        <div class="col-4 col-lg-4 d-flex flex-column">
                            {{-- Latest Message from the chat --}}
                            <p class="text-end">
                                {{ $chat->latestMessage ? $chat->latestMessage->created_at->diffForHumans() : __('chat.no_messages') }}
                            </p>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-center">{{ _('chat.no_chat') }}</p>
            @endif

        </div>
    </div>

@endsection
