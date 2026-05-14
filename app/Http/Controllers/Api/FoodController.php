<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;
class FoodController extends Controller
{
    //semua makanan
    public function index()
    {
        $foods = Food::with('province')->get();
        return response()->json($foods);
    }

    //detail makanan
    public function show(Request $request, $id)
    {
        $lang = $request->query('lang', 'id');
        $food = Food::with('province')->find($id);
        if (!$food) {
            return response()->json([
                'message' => 'Makanan tidak ditemukan'
            ], 404);
        }
        //Jika bahasa English
        if ($lang == 'en') {
            $food->description = $food->description_en;
            $food->ingredients = $food->ingredients_en;
            $food->recipe = $food->recipe_en;
        }

        return response()->json($food);
    }
    //makanan provensi
    public function byProvince($province_id)
    {
        $foods = Food::where('province_id', $province_id)
            ->with('province')
            ->get();
        return response()->json($foods);
    }
    //makanan
    public function search(Request $request)
    {
        $query = $request->query('query');
        $foods = Food::where('name', 'like', "%{$query}%")
            ->with('province')
            ->get();
        return response()->json($foods);
    }
}
