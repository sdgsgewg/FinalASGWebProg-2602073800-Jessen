<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="{{ __('navbar.toggle_navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">

                {{-- Search Bar --}}
                @include('components.navbar.search-bar')

                {{-- Filter By Gender --}}
                @include('components.navbar.gender-filter')

                {{-- Localization --}}
                @include('components.navbar.localization-menu')

                <!-- Authentication Links -->
                @include('components.navbar.user-dropdown')
            </ul>
        </div>
    </div>
</nav>

<script>
    function validateSearch(form) {
        const searchInput = form.search.value.trim();
        if (!searchInput) {
            console.warn("Search input is empty.");
            return false; // Prevent form submission
        }
        return true; // Allow form submission
    }
</script>
