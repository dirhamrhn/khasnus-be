<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(): JsonResponse
    {
        $users = User::orderBy('id', 'desc')->get();

        return response()->json([
            'status' => true,
            'message' => 'Daftar pengguna berhasil diambil',
            'data' => $users
        ]);
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Pengguna tidak ditemukan',
                'data' => null
            ], 404);
        }

        // Prevent admin from deleting themselves
        if (auth()->id() === $user->id) {
            return response()->json([
                'status' => false,
                'message' => 'Anda tidak dapat menghapus akun Anda sendiri',
                'data' => null
            ], 400);
        }

        $user->delete();

        return response()->json([
            'status' => true,
            'message' => 'Pengguna berhasil dihapus',
            'data' => null
        ]);
    }
}
