<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class AuthController extends Controller
{
    // Redirect ke Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Callback dari Google
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        // cek user berdasarkan email
        $user = User::where('email', $googleUser->email)->first();

        // kalau belum ada → buat user baru
        if (!$user) {
            $user = User::create([
                'username' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'avatar' => $googleUser->avatar,
                'password' => null,
                'role' => 'user'
            ]);
        }

        return response()->json([
            'message' => 'Login Google berhasil',
            'user' => $user
        ]);
    }
}