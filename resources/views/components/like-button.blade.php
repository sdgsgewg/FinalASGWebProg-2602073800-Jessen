<form action="{{ route('wishlists.store') }}" method="POST" class="d-inline">
    @csrf
    <input type="hidden" name="targetUserId" value="{{ $user->id }}">
    <button type="submit"
        class="btn {{ $inWishlist || $isFollowing ? 'btn-secondary' : 'btn-primary' }} btn-sm d-inline-flex"
        {{ $inWishlist || $isFollowing ? 'disabled' : '' }}>
        <i class="bi bi-hand-thumbs-up me-1"></i>
        {{ __('user.like') }}
    </button>
</form>
