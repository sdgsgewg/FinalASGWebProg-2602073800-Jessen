<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Following;
use App\Models\Notification;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $followerId = $request->followerId;
        $followedId = Auth::user()->id;
    
        // Tambah data ke tabel followings
        $following = Following::create([
            'follower_id' => $followerId,
            'followed_id' => $followedId,
        ]);
    
        // Tambah data ke tabel chats
        $chat = Chat::create([
            'user_1_id' => $followerId,
            'user_2_id' => $followedId,
        ]);
    
        // Ambil dan hapus wishlist
        $wishlist = Wishlist::where('user_id', $followerId)
            ->where('target_user_id', $followedId)
            ->first();
    
        Wishlist::destroy($wishlist->id);
    
        // **Tambah notifikasi untuk follower**
        Notification::create([
            'user_id' => $followerId, // Penerima notifikasi
            'type' => 'friend_request_acc',
            'title' => 'Permintaan Pertemanan Disetujui',
            'message' => Auth::user()->name . ' telah menerima permintaan pertemanan Anda.',
            'related_id' => $followedId, // ID pengguna terkait
            'related_type' => 'App\Models\User', // Model terkait
            'priority' => 'medium',
        ]);
    
        return redirect()->back()->with('success', __('following.friend_added_msg'));
    }    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
