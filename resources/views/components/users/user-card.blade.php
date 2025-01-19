<style>
    .card-hover {
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }
</style>

<div class="card card-hover mb-3 h-100"
    onclick="{{ "window.location.href='" . route('users.show', ['user' => $user->id]) . "'" }}">
    <div class="card-body d-flex flex-column h-100">
        <div class="d-flex justify-content-center h-70">
            {{-- @if ($user->randomImage)
                <img src="{{ $user->randomImage }}" alt="Random Image" style="max-width: 100%; height: auto;">
            @else
                <img src="{{ asset('img/' . $user['randomHobby'] . '.png') }}" alt="{{ $user['randomHobby'] }}"
                    style="max-width: 100%; height: auto;">
            @endif --}}
            <img src="https://picsum.photos/id/{{ $user['id'] }}/100" alt=""
                style="max-width: 100%; height: auto;">
        </div>
        <div class="d-flex flex-column mt-4 h-20">
            <h5>{{ $user->name }}</h5>
            <p>{{ __('user.' . strtolower($user->gender)) }}</p>
            <p class="mb-0">
                {{ __('user.hobbies') }}
                @if (!empty(json_decode($user->hobbies, true)))
                    @foreach (json_decode($user->hobbies, true) as $hobby)
                        <span class="badge bg-info text-dark me-1">{{ __('user.hobby.' . $hobby) }}</span>
                    @endforeach
                @else
                    <span class="text-muted">{{ __('user.not_specified') }}</span>
                @endif
            </p>
        </div>
        @auth
            <div class="d-flex justify-content-end align-items-center text-center gap-3 mt-4 h-10">
                @if (auth()->user()->id !== $user->id)
                    @include('components.like-button', [
                        'user' => $user,
                        'inWishlist' => $user->inWishlist,
                        'isFollowing' => $user->isFollowing,
                    ])
                @endif
            </div>
        @endauth
    </div>
</div>
