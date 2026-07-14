<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * Register a new user and return user details and token.
     */
    public function register(array $data)
    {
        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'user' // default role
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    /**
     * Login a user and return user details and token.
     */
    public function login(array $data)
    {
        $loginField = filter_var($data['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $user = User::where($loginField, $data['login'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'login' => ['Email atau password salah.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    /**
     * Logout user by revoking token.
     */
    public function logout(User $user)
    {
        return $user->currentAccessToken()->delete();
    }
}
