@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- Title --}}
        <div class="row justify-content-center my-4">
            <div class="col-md-8">
                <h1>{{ __('notification.title') }}</h1>
            </div>
        </div>

        {{-- Notification List --}}
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if ($notifications->count())
                    <div class="row d-flex flex-wrap align-items-stretch">
                        @foreach ($notifications as $notification)
                            <div class="col-12 mb-4">
                                {{-- Notification Card --}}
                                @include('components.notification-card')
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center">
                        {{ __('notification.no_notif') }}
                    </p>
                @endif
            </div>
        </div>

    </div>
@endsection
