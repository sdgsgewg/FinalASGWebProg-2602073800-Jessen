@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- Title --}}
        <div class="row justify-content-center my-4">
            <div class="col-md-8">
                <h1>{{ __('home.title') }}</h1>
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
