<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::user()->id;
        $notifications = Notification::where('user_id', $userId)->get();

        $notifications = $notifications->map(function($notification) use ($userId) {
            
            if ($notification['type'] === 'chat_message_sent') {
                $chat = Chat::where('id', $notification->related_id)->first();
                $sender = $userId !== $chat->user1->id ? $chat->user1 : $chat->user2;
                $relatedUser = User::where('id', $sender->id)->first();
                $notification->relatedUserName = $relatedUser->name;
            } else {
                $relatedUser = User::where('id', $notification['related_id'])->first();
                $notification->relatedUserName = $relatedUser->name;
            }

            return $notification;
        });

        return view('notifications.index', [
            'notifications' => $notifications,
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Notification $notification)
    {
        if ($notification['type'] === 'friend_request_sent') {
            $notification->update([
                'read' => true,
            ]);
            $notification->save();
            
            return redirect()->route('users.friend-req');
        } else if ($notification['type'] === 'friend_request_acc') {
            $notification->update([
                'read' => true,
            ]);
            $notification->save();

            return redirect()->route('users.index');
        } else if ($notification['type'] === 'chat_message_sent') {
            $notification->update([
                'read' => true,
            ]);
            $notification->save();

            return redirect()->route('chats.show', [
                'chat' => $notification['related_id'],
            ]);
        }

        return redirect()->back()->withErrors(['status' => 'Notification Type is not valid.']);
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
