<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
    // Cek apakah chat dengan ID tertentu ada dan apakah pengguna adalah salah satu partisipan
    $chat = \App\Models\Chat::find($chatId);

    // Pastikan chat ada dan pengguna adalah salah satu dari user_1_id atau user_2_id
    return $chat && ($chat->user_1_id === $user->id || $chat->user_2_id === $user->id);
});
