<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Following;
use App\Models\Notification;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wishlists = Wishlist::where('user_id', Auth::user()->id)->get();

        return view('wishlists.index', [
            'wishlists' => $wishlists,
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
        $userId = Auth::user()->id;
        $targetUserId = $request->targetUserId;

        // Untuk mengetahui apakah target user memiliki wishlist untuk berteman dengan user yang sedang login
        $targetUserWishlist = Wishlist::where('user_id', $targetUserId)
        ->where('target_user_id', $userId)
        ->first();

        if ($targetUserWishlist) {
            // Masukkan data ke tabel 'followings'
            $following = Following::create([
                'follower_id' => $targetUserId,
                'followed_id' => $userId,
            ]);
            $following->save();

            // Masukkan data ke tabel 'chats'
            $chat = Chat::create([
                'user_1_id' => $targetUserId,
                'user_2_id' => $userId,
            ]);
            $chat->save();

            // Ambil data wishlist milik targetUser yang mengarah ke pengguna yang sedang login
            $wishlist = Wishlist::where('user_id', $targetUserId)
            ->where('target_user_id', $userId)
            ->first();
            
            // Hapus wishlist dari follower
            Wishlist::destroy($wishlist->id);

            // **Tambah notifikasi untuk targetUser**
            Notification::create([
                'user_id' => $targetUserId, // Penerima notifikasi
                'type' => 'friend_request_acc',
                'title' => 'Permintaan Pertemanan Disetujui',
                'message' => 'Permintaan pertemanan Anda dengan ' . Auth::user()->name . ' telah diterima.',
                'related_id' => $userId, // ID pengguna terkait
                'related_type' => 'App\Models\User', // Model terkait
                'priority' => 'medium',
            ]);

            return redirect()->back()->with('success', __('following.friend_added_msg'));
        }

        $wishlist = Wishlist::create([
            'user_id' => Auth::user()->id,
            'target_user_id' => intval($targetUserId)
        ]);
        $wishlist->save();

        // **Tambah notifikasi untuk targetUser**
        Notification::create([
            'user_id' => $targetUserId, // Penerima notifikasi
            'type' => 'friend_request_sent',
            'title' => 'Permintaan Pertemanan Baru',
            'message' => Auth::user()->name . ' telah mengirim permintaan pertemanan kepada Anda.',
            'related_id' => $userId, // ID pengguna terkait
            'related_type' => 'App\Models\User', // Model terkait
            'priority' => 'medium',
        ]);

        return redirect()->back()->with('success', __('wishlist.add_wishlist_msg'));
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
    public function destroy(Wishlist $wishlist)
    {
        Wishlist::destroy($wishlist->id);

        return redirect()->back()->with('success', __('wishlist.remove_user_msg'));
    }
}
