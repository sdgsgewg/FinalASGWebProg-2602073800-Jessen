<?php

namespace App\Http\Controllers;

use App\Models\Following;
use App\Models\User;
use App\Models\Wishlist;
use App\Services\PexelsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected $pexelsService;

    public function __construct(PexelsService $pexelsService)
    {
        // $this->middleware('auth');
        $this->pexelsService = $pexelsService;
    }

    private function checkWishlist($user)
    {
        // Cek Wishlist
        $loggedInUser = Auth::user();
            
        $wishlist = Wishlist::
        where('user_id', $loggedInUser->id)
        ->where('target_user_id', $user->id)
        ->get();

        $inWishlist = false;
        if ($wishlist->count() > 0) {
            $inWishlist = true;
        }

        $user->inWishlist = $inWishlist;
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

        $user->isFollowing = $isFollowing;
    }

    public function index()
    {
        // Fetch All Users
        $users = User::paginate(2);

        $users->getCollection()->transform(function ($user) {
            $hobbies = json_decode($user->hobbies, true); // Ambil data hobi
            $randomHobby = $hobbies[array_rand($hobbies)] ?? 'nature'; // Pilih hobi acak

            $user->randomHobby = $randomHobby;

            // Ambil gambar berdasarkan hobi
            $user->randomImage = $this->pexelsService->getRandomImage($randomHobby);

            if (auth()->check())
            {
                $this->checkWishlist($user);
                $this->checkFollowing($user);
            }

            return $user;
        });

        return view('home', [
            'users' => $users
        ]);
    }

    public function filterByGender(Request $request)
    {
        $request->validate([
            'gender' => 'nullable|string',
        ]);

        $gender = strtolower(request('gender'));

        $users = User::where('gender', $gender)->paginate(2);

        $users->getCollection()->transform(function ($user) {
            $hobbies = json_decode($user->hobbies, true); // Ambil data hobi
            $randomHobby = $hobbies[array_rand($hobbies)] ?? 'nature'; // Pilih hobi acak

            $user->randomHobby = $randomHobby;

            // Ambil gambar berdasarkan hobi
            $user->randomImage = $this->pexelsService->getRandomImage($randomHobby);
            return $user;
        });

        return view('filtered-users', [
            'users' => $users
        ]);
    }

    public function searchByHobby(Request $request)
    {
        $request->validate([
            'search' => 'required|string',
        ]);

        $hobby = strtolower(request('search'));
        
        // Fetch all users where the 'hobbies' JSON column contains the given hobby (case-insensitive)
        $users = User::whereRaw('LOWER(hobbies) LIKE ?', ['%' . $hobby . '%'])->paginate(2);
    
        // Iterate over the users and check for matching hobbies
        $users->getCollection()->transform(function ($user) use ($hobby) {
            // Decode the hobbies JSON data
            $hobbies = json_decode($user->hobbies, true); 
    
            $userHobby = '';
    
            foreach ($hobbies as $h) {
                if (strtolower($h) === $hobby) {
                    $userHobby = $h;
                    break;
                }
            }

            // If a hobby is found, fetch the random image based on that hobby
            if ($userHobby) {
                $user->randomHobby = $userHobby;

                $user->randomImage = $this->pexelsService->getRandomImage($userHobby);
            } else {
                $hobbies = json_decode($user->hobbies, true); // Ambil data hobi
                $randomHobby = $hobbies[array_rand($hobbies)] ?? 'nature'; // Pilih hobi acak
    
                $user->randomHobby = $randomHobby;
                // Handle the case where no matching hobby is found, e.g., set a default image
                $user->randomImage = $this->pexelsService->getRandomImage(); // Default image
            }
    
            return $user;
        });
    
        // Return the view with the filtered users
        return view('filtered-users', [
            'users' => $users
        ]);
    }    
}
