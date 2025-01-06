<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
    return \App\Models\Chat::where('id', $chatId)
        ->where(function ($query) use ($user) {
            $query->where('user_1_id', $user->id)
                  ->orWhere('user_2_id', $user->id);
        })->exists();
});

