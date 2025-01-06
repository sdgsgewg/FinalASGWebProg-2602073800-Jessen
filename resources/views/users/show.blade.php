@extends('layouts.app')

@section('content')
    <div class="container py-5">
        {{-- Title --}}
        <div class="row justify-content-center mb-5">
            <div class="col-md-8 text-center">
                <h1 class="display-5 fw-bold text-primary">{{ __('user.title.detail') }}</h1>
                <p class="text-muted">{{ __('user.description.detail') }}</p>
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
                            @include('components.like-button')
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
