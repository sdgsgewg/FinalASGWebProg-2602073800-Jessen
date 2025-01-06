@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- Title --}}
        <div class="row justify-content-center my-4">
            <div class="col-md-8">
                <h1>{{ __('following.title') }}</h1>
            </div>
        </div>

        <div class="row justify-content-center">
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show col-md-8" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        {{-- Followers List --}}
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if ($followers->count())
                    <div class="row d-flex flex-wrap align-items-stretch">
                        @foreach ($followers as $follower)
                            <div class="col-12 col-md-6 mb-4">
                                @include('components.users.friend-req-card', [
                                    'user' => $follower->user,
                                ])
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center">{{ __('following.no_friend_req') }}</p>
                @endif
            </div>
        </div>

    </div>
@endsection
