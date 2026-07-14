<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FavoriteService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FavoriteController extends Controller
{
    protected FavoriteService $favoriteService;

    public function __construct(FavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

    /**
     * Display a listing of user's favorite foods.
     */
    public function index(Request $request): JsonResponse
    {
        $userId = $request->user()->id;
        $favorites = $this->favoriteService->getFavorites($userId);

        return response()->json([
            'status' => true,
            'message' => 'Daftar makanan favorit berhasil diambil',
            'data' => $favorites
        ]);
    }

    /**
     * Store a newly created favorite in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'food_id' => 'required|integer'
        ]);

        $userId = $request->user()->id;

        try {
            $favorite = $this->favoriteService->addFavorite($userId, $request->input('food_id'));

            return response()->json([
                'status' => true,
                'message' => 'Makanan berhasil ditambahkan ke favorit',
                'data' => $favorite
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Remove the specified favorite from storage.
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $userId = $request->user()->id;
        $deleted = $this->favoriteService->removeFavorite($userId, $id);

        if (!$deleted) {
            return response()->json([
                'status' => false,
                'message' => 'Favorit tidak ditemukan atau tidak memiliki akses',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Makanan berhasil dihapus dari favorit',
            'data' => null
        ]);
    }
}
