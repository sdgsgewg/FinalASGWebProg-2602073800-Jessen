<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Following;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $followings = Following::where('follower_id', $user->id)
        ->orWhere('followed_id', $user->id)
        ->get();

        return view('users.profile', [
            'user' => $user,
            'followings' => $followings,
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

     private function checkWishlist($user)
     {
         $loggedInUser = Auth::user();
             
         $wishlist = Wishlist::
         where('user_id', $loggedInUser->id)
         ->where('target_user_id', $user->id)
         ->first();
 
         $inWishlist = false;
         if ($wishlist) {
             $inWishlist = true;
         }

         return $inWishlist;
    }

    private function checkFollowing($user)
    {
        $loggedInUser = Auth::user();

        $following1 = Following::
        where('follower_id', $user->id)
        ->where('followed_id', $loggedInUser->id)
        ->first();

        $following2 = Following::
        where('follower_id', $loggedInUser->id)
        ->where('followed_id', $user->id)
        ->first();

        $isFollowing = false;
        if ($following1 || $following2) {
            $isFollowing = true;
        }

        return $isFollowing;
    }

    public function show(User $user)
    {
        $loggedInUser = Auth::user();
        $user = User::where('id', $user->id)->first();

        $inWishlist = $this->checkWishlist($user);
        $isFollowing = $this->checkFollowing($user);
        $chat = null;

        if ($isFollowing) {
            $chat1 = Chat::where('user_1_id', $user->id)
            ->where('user_2_id', $loggedInUser->id)
            ->first();

            $chat2 = Chat::where('user_1_id', $loggedInUser->id)
            ->where('user_2_id', $user->id)
            ->first();

            if ($chat1) {
                $chat = $chat1;
            } else {
                $chat = $chat2;
            }
        }

        return view('users.show', [
            'user' => $user,
            'inWishlist' => $inWishlist,
            'isFollowing' => $isFollowing,
            'chat' => $chat,
        ]);
    }

    public function showFriendRequest()
    {
        $user = Auth::user();

        $followers = Wishlist::where('target_user_id', $user->id)->get();

        return view('friend-request', [
            'followers' => $followers,
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
