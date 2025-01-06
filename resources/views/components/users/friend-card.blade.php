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
    <div class="card-body">
        <div class="d-flex flex-column mt-3 h-40">
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
    </div>
</div>
