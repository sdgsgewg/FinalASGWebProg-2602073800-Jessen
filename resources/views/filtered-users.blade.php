@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- Title --}}
        <div class="row justify-content-center my-4">
            <div class="col-md-8">
                <h1>{{ __('home.title') }}</h1>
            </div>
        </div>

        {{-- User Lists --}}
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if ($users->count())
                    <div class="row d-flex flex-wrap align-items-stretch">
                        @foreach ($users as $user)
                            <div class="col-12 col-md-6 mb-4">
                                @include('components.users.user-card')
                            </div>
                        @endforeach
                    </div>
                @else
                <div>
                    <p class="text-center">{{ __('home.no_users') }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Paginator --}}
        <div class="row justify-content-center mt-4">
            <div class="col-md-8 d-flex justify-content-center">
                {{ $users->links() }}
            </div>
        </div>

    </div>
@endsection
