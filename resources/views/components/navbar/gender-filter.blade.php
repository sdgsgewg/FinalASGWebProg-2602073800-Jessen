<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        {{ __('auth.gender') }}
    </a>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item {{ request('gender') == 'male' ? 'active' : '' }}"
                href="{{ route('filter', ['gender' => 'male']) }}">{{ __('auth.male') }}</a>
        </li>
        <li><a class="dropdown-item {{ request('gender') == 'female' ? 'active' : '' }}"
                href="{{ route('filter', ['gender' => 'female']) }}">{{ __('auth.female') }}</a>
        </li>
    </ul>
</li>
