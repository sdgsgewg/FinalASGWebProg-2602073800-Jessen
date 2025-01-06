<?php

namespace App\Http\Controllers;

use App\Services\UnsplashService;

class UnsplashController extends Controller
{
    protected $unsplashService;

    public function __construct(UnsplashService $unsplashService)
    {
        $this->unsplashService = $unsplashService;
    }

    public function showRandomImage()
    {
        $imageUrl = $this->unsplashService->getRandomImage('nature'); // Bisa diubah query-nya
        return view('random-image', ['imageUrl' => $imageUrl]);
    }
}
