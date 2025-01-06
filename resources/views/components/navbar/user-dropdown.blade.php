@guest
    @if (Route::has('login'))
        <li class="nav-item">
            <a class="nav-link d-inline-flex" href="{{ route('login') }}">
                <i class="bi bi-box-arrow-in-right me-2"></i>
                {{ __('navbar.login') }}
            </a>
        </li>
    @endif

    @if (Route::has('register'))
        <li class="nav-item">
            <a class="nav-link d-inline-flex" href="{{ route('register') }}">
                <i class="bi bi-person-plus me-2"></i>
                {{ __('navbar.register') }}
            </a>
        </li>
    @endif
@else
    <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false" v-pre>
            {{ Auth::user()->name }}
        </a>

        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <a class="dropdown-item d-inline-flex {{ Request::is('wishlists*') ? 'active' : '' }}"
                href="{{ route('wishlists.index') }}">
                <i class="bi bi-heart me-2"></i>
                {{ __('navbar.wishlist') }}
            </a>

            <a class="dropdown-item d-inline-flex {{ Request::is('users/friend-requests') ? 'active' : '' }}"
                href="{{ route('users.friend-req') }}">
                <i class="bi bi-person-add me-2"></i>
                {{ __('navbar.friend_req') }}
            </a>

            <a class="dropdown-item d-inline-flex {{ Request::is('chats*') ? 'active' : '' }}"
                href="{{ route('chats.index') }}">
                <i class="bi bi-chat-dots me-2"></i>
                {{ __('navbar.chats') }}
            </a>

            <a class="dropdown-item d-inline-flex {{ Request::is('notifications*') ? 'active' : '' }}"
                href="{{ route('notifications.index') }}">
                <i class="bi bi-bell me-2"></i>
                {{ __('navbar.notifications') }}
            </a>

            <a class="dropdown-item d-inline-flex {{ Request::is('users') ? 'active' : '' }}"
                href="{{ route('users.index') }}">
                <i class="bi bi-person-circle me-2"></i>
                {{ __('navbar.profile') }}
            </a>

            <hr class="dropdown-divider">

            <a class="dropdown-item d-inline-flex" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-in-left me-2"></i>
                {{ __('navbar.logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </li>
@endguest
