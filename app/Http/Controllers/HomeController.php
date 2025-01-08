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
        $users = User::paginate(4);

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

    public function filterUsers(Request $request)
    {
        // Validasi input
        $request->validate([
            'gender' => 'nullable|string',
            'search' => 'nullable|string',
        ]);
    
        // Mulai query builder
        $query = User::query();
    
        $gender = null;
        // Filter berdasarkan gender jika ada
        if ($request->has('gender') && !empty($request->gender)) {
            $gender = strtolower($request->gender);
            $query->where('gender', $gender); // Apply gender filter
        }
    
        $hobby = null;
        // Filter berdasarkan hobi jika ada
        if ($request->has('search') && !empty($request->search)) {
            $hobby = strtolower($request->search);
            $query->whereRaw('LOWER(hobbies) LIKE ?', ['%' . $hobby . '%']); // Apply hobby filter
        }
    
        // Ambil hasil query dengan paginasi
        $users = $query->paginate(4);
    
        // Proses data untuk menambahkan informasi hobi acak dan gambar terkait
        $users->getCollection()->transform(function ($user) use ($hobby) {
            $hobbies = json_decode($user->hobbies, true);
            $randomHobby = '';
    
            if (isset($hobby)) {
                // Jika ada hobi yang dicari, cari hobi yang cocok
                $userHobby = '';
                foreach ($hobbies as $h) {
                    if (strtolower($h) === $hobby) {
                        $userHobby = $h;
                        break;
                    }
                }
    
                // Jika hobi ditemukan, set hobi acak dengan hobi yang ditemukan
                if ($userHobby) {
                    $randomHobby = $userHobby;
                }
            }
    
            if (!$randomHobby) {
                // Pilih hobi acak jika tidak ditemukan kecocokan
                $randomHobby = $hobbies[array_rand($hobbies)] ?? 'nature';
            }
    
            $user->randomHobby = $randomHobby;
    
            // Ambil gambar berdasarkan hobi
            $user->randomImage = $this->pexelsService->getRandomImage($randomHobby);
    
            return $user;
        });
    
        // Return the view with filtered users
        return view('filtered-users', [
            'users' => $users
        ]);
    }

}
