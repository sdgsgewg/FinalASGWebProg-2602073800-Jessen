@extends('layouts.app')

@section('content')
    <div class="container py-5">
        {{-- Title --}}
        <div class="row justify-content-center mb-5">
            <div class="col-md-8 text-center">
                <h1 class="display-5 fw-bold text-primary">{{ __('user.title.profile') }}</h1>
                <p class="text-muted">{{ __('user.description.profile') }}</p>
            </div>
        </div>

        {{-- User Detail --}}
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0">
                    {{-- Name --}}
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">{{ $user['name'] }}</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            {{-- Gender --}}
                            <li class="list-group-item">
                                <strong>{{ __('user.wallet') }}</strong>
                                {{ 'Rp' . number_format($user['wallet_balance'], '2', ',', '.') }}
                            </li>

                            {{-- Gender --}}
                            <li class="list-group-item">
                                <strong>{{ __('user.gender') }}</strong> {{ $user['gender'] }}
                            </li>

                            {{-- Email --}}
                            <li class="list-group-item">
                                <strong>{{ __('user.email') }}</strong> {{ $user['email'] }}
                            </li>

                            {{-- Hobbies --}}
                            <li class="list-group-item">
                                <strong>{{ __('user.hobbies') }}</strong>
                                @if (!empty(json_decode($user->hobbies, true)))
                                    @foreach (json_decode($user->hobbies, true) as $hobby)
                                        <span class="badge bg-info text-dark me-1">{{ __('user.hobby.' . $hobby) }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">{{ __('user.not_specified') }}</span>
                                @endif
                            </li>

                            {{-- Instagram --}}
                            <li class="list-group-item">
                                <strong>{{ __('user.insta_username') }}</strong>
                                <a href="{{ $user['instagram_username'] }}" target="_blank"
                                    class="text-decoration-none text-info">
                                    {{ '@' . $user['instagram_username'] }}
                                </a>
                            </li>

                            {{-- Mobile Number --}}
                            <li class="list-group-item">
                                <strong>{{ __('user.mobile_number') }}</strong> {{ $user['mobile_number'] }}
                            </li>

                            {{-- Preferred Meeting Location --}}
                            <li class="list-group-item">
                                <strong>{{ __('user.pref_loc') }}</strong> {{ $user['preferred_location'] }}
                            </li>
                        </ul>
                    </div>

                    @if (auth()->user()->id !== $user->id)
                        <div
                            class="card-footer d-flex justify-content-center align-items-center text-center gap-3 bg-light">
                            <button class="btn btn-danger btn-sm d-iniline-flex">
                                <i class="bi bi-hand-thumbs-down me-1"></i>
                                {{ __('user.dislike') }}
                            </button>
                            <button class="btn btn-primary btn-sm d-iniline-flex">
                                <i class="bi bi-hand-thumbs-up me-1"></i>
                                {{ __('user.like') }}
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Friend List --}}
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="row justify-content-center my-5">
                    <div class="col-md-8 text-center">
                        <h1 class="display-5 fw-bold text-primary">{{ __('user.friend_list') }}</h1>
                        <p class="text-muted">{{ __('user.friend_list_desc') }}</p>
                    </div>
                </div>
                @if ($followings->count())
                    <div class="row d-flex flex-wrap align-items-stretch">
                        @foreach ($followings as $following)
                            <div class="col-12 col-md-6 mb-4">
                                @include('components.users.friend-card', [
                                    'user' => $following->followed,
                                ])
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center">
                        {{ __('user.no_friends') }}
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection
