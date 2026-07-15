<?php

namespace App\Services;

use App\Models\Favorite;
use App\Models\Food;
use Illuminate\Validation\ValidationException;

class FavoriteService
{
    /**
     * Get user's favorite foods.
     */
    public function getFavorites(int $userId)
    {
        return Favorite::where('user_id', $userId)
            ->with([
                'food' => fn($query) => $query->withCount('favorites'),
                'food.province'
            ])
            ->get();
    }

    /**
     * Add a food to user's favorites.
     */
    public function addFavorite(int $userId, int $foodId)
    {
        // Pastikan makanannyaa ada
        $foodExists = Food::where('id', $foodId)->exists();
        if (!$foodExists) {
            throw ValidationException::withMessages([
                'food_id' => ['Makanan tidak ditemukan.'],
            ]);
        }

        // Pastikan belum ada di favorit
        $alreadyFavorite = Favorite::where('user_id', $userId)
            ->where('food_id', $foodId)
            ->first();

        if ($alreadyFavorite) {
            return $alreadyFavorite;
        }

        return Favorite::create([
            'user_id' => $userId,
            'food_id' => $foodId
        ]);
    }

    /**
     * Remove a food from user's favorites.
     */
    public function removeFavorite(int $userId, int $favoriteId): bool
    {
        $favorite = Favorite::where('id', $favoriteId)
            ->where('user_id', $userId)
            ->first();

        if (!$favorite) {
            return false;
        }

        return $favorite->delete();
    }
}
