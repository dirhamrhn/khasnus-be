<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Register manual.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->authService->register($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Registrasi berhasil',
            'data' => [
                'user' => $result['user'],
                'token' => $result['token']
            ]
        ], 201);
    }

    /**
     * Login manual.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $result = $this->authService->login($request->validated());

            return response()->json([
                'status' => true,
                'message' => 'Login berhasil',
                'data' => [
                    'user' => $result['user'],
                    'token' => $result['token']
                ]
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Logout.
     */
    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();
        if ($user) {
            $this->authService->logout($user);
            return response()->json([
                'status' => true,
                'message' => 'Logout berhasil',
                'data' => null
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Pengguna tidak terautentikasi',
            'data' => null
        ], 401);
    }

    /**
     * Redirect ke Google.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Callback dari Google.
     */
    public function handleGoogleCallback()
    {
        try {
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

            // Buat token Sanctum untuk login Google
            $token = $user->createToken('auth_token')->plainTextToken;

            $frontendUrl = 'http://localhost:5173/login';
            $query = http_build_query([
                'token' => $token,
                'user' => json_encode([
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'role' => $user->role,
                    'avatar' => $user->avatar
                ])
            ]);

            return redirect($frontendUrl . '?' . $query);
        } catch (\Exception $e) {
            return redirect('http://localhost:5173/login?error=' . urlencode('Login Google gagal: ' . $e->getMessage()));
        }
    }
}