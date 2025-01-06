<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        {{ __('navbar.language') }}
    </a>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }}"
                href="{{ route('changeLanguage', ['lang' => 'en']) }}">{{ __('navbar.english') }}</a>
        </li>
        <li><a class="dropdown-item {{ app()->getLocale() == 'id' ? 'active' : '' }}"
                href="{{ route('changeLanguage', ['lang' => 'id']) }}">{{ __('navbar.indo') }}</a>
        </li>
    </ul>
</li>
