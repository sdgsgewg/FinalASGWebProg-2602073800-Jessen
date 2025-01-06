<style>
    .card-hover {
        cursor: pointer;
        transition: box-shadow 0.2s;
    }

    .card-hover:hover {
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }
</style>

<div class="card card-hover {{ !$notification['read'] ? 'bg-info' : '' }} mb-3 h-100"
    onclick="{{ "window.location.href='" . route('notifications.show', ['notification' => $notification->id]) . "'" }}">
    <div class="card-body d-flex flex-column justify-content-between">
        <div>
            <!-- Notification Title -->
            <h5 class="card-title">
                @if ($notification['type'] === 'friend_request_sent')
                    {{ __('notification.friend_req_title') }}
                @elseif ($notification['type'] === 'friend_request_acc')
                    {{ __('notification.friend_req_acc_title') }}
                @elseif ($notification['type'] === 'chat_message_sent')
                    {{ __('notification.chat_msg_title') }}
                @endif
            </h5>

            <!-- Notification Message -->
            <p class="card-text">
                @if ($notification['type'] === 'friend_request_sent')
                    {{ $notification->relatedUserName . ' ' . __('notification.friend_req_sent') }}
                @elseif ($notification['type'] === 'friend_request_acc')
                    {{ __('notification.friend_req_acc_1') . ' ' . $notification->relatedUserName . ' ' . __('notification.friend_req_acc_2') }}
                @elseif ($notification['type'] === 'chat_message_sent')
                    {{ $notification->relatedUserName . ' ' . __('notification.chat_msg_sent') }}
                @endif
            </p>

            <!-- Notification Timestamp -->
            <p class="card-text">
                <small class="text-muted">
                    @if ($notification['type'] === 'friend_request_acc')
                        {{ __('notification.accepted_on') .' ' .\Carbon\Carbon::parse($notification->created_at)->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                    @else
                        {{ __('notification.sent_on') .' ' .\Carbon\Carbon::parse($notification->created_at)->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                    @endif
                </small>
            </p>
        </div>

        <!-- Notification Actions -->
        <div class="d-flex justify-content-end gap-2 mt-auto">
            <button class="btn btn-primary btn-sm">{{ __('notification.view') }}</button>
        </div>
    </div>
</div>
