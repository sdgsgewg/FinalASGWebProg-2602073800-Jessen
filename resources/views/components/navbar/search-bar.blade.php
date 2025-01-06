<form class="d-flex me-0 me-lg-3 my-3 my-lg-0" action="{{ route('search') }}" method="GET" role="search"
    onsubmit="return validateSearch(this)">
    <input class="form-control me-2" type="search" placeholder="{{ __('navbar.search_placeholder') }}" name="search"
        value="{{ request('search') }}" aria-label="Search">
    <button class="btn btn-outline-success" type="submit">
        {{ __('navbar.search') }}
    </button>
</form>
