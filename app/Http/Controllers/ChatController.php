<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\Following;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $chats = Chat::where('user_1_id', $user->id)
            ->orWhere('user_2_id', $user->id)
            ->get();
    
        // Transform the collection using map()
        $chats = $chats->map(function ($chat) use ($user) {
            // Create a recipient field for chat
            $recipient = $user->id === $chat->user1->id ? $chat->user2 : $chat->user1;
    
            $chat->recipient = $recipient;
    
            // Create a latestMessage field for chat
            $latestMessage = $chat->messages->last();
            $chat->latestMessage = $latestMessage;
    
            return $chat;
        });
    
        return view('chats.chat-list', [
            'chats' => $chats
        ]);
    }    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    // Store message in a chat
    // public function store(Request $request)
    // {
    //     $chat = Chat::findOrFail($request->chat);
    
    //     $request->validate([
    //         'message' => 'required|string|max:255',
    //     ]);
    
    //     $message = ChatMessage::create([
    //         'chat_id' => $chat->id,
    //         'sender_id' => Auth::user()->id,
    //         'message_text' => $request->message,
    //     ]);
    //     $message->save();
    
    //     // Dapatkan ID penerima (user lain dalam chat)
    //     $recipientId = $chat->user_1_id === Auth::user()->id ? $chat->user_2_id : $chat->user_1_id;
    
    //     // Buat notifikasi untuk penerima
    //     Notification::create([
    //         'user_id' => $recipientId, // Penerima notifikasi
    //         'type' => 'chat_message_sent',
    //         'title' => 'Pesan Baru',
    //         'message' => Auth::user()->name . ' mengirimkan pesan baru kepada Anda.',
    //         'related_id' => $chat->id, // ID chat terkait
    //         'related_type' => 'App\Models\Chat', // Model terkait
    //         'priority' => 'medium',
    //     ]);
    
    //     // Siarkan Event
    //     broadcast(new MessageSent($message))->toOthers();
    
    //     // Kembalikan ke halaman chat setelah pesan terkirim
    //     return redirect()->route('chats.show', ['chat' => $chat->id]);
    // }
    
    public function store(Request $request)
    {
        $chat = Chat::findOrFail($request->chat);
    
        $request->validate([
            'message' => 'required|string|max:255',
        ]);
    
        $message = ChatMessage::create([
            'chat_id' => $chat->id,
            'sender_id' => Auth::user()->id,
            'message_text' => $request->message,
        ]);

        // Dapatkan ID penerima (user lain dalam chat)
        $recipientId = $chat->user_1_id === Auth::user()->id ? $chat->user_2_id : $chat->user_1_id;
    
        // Buat notifikasi untuk penerima
        Notification::create([
            'user_id' => $recipientId, // Penerima notifikasi
            'type' => 'chat_message_sent',
            'title' => 'Pesan Baru',
            'message' => Auth::user()->name . ' mengirimkan pesan baru kepada Anda.',
            'related_id' => $chat->id, // ID chat terkait
            'related_type' => 'App\Models\Chat', // Model terkait
            'priority' => 'medium',
        ]);
    
        // Siarkan event untuk real-time update
        broadcast(new MessageSent($message))->toOthers();
    
        // Pastikan respon berupa JSON
        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    // Show chat conversation between two users
    public function show(Chat $chat)
    {
        $userId = Auth::user()->id;

        $user1 = $chat->user1;
        $user2 = $chat->user2;

        // Determine recipient based on logged-in user
        $recipient = ($userId !== $user1->id) ? $user1 : $user2;
    
        return view('chats.chat-box', [
            'title' => 'Chat',
            'chat' => $chat,
            'recipient' => $recipient,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
