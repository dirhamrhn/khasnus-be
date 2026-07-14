<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFoodRequest;
use App\Http\Requests\UpdateFoodRequest;
use App\Services\FoodService;
use App\Models\Food;
use Illuminate\Http\JsonResponse;

class FoodController extends Controller
{
    protected FoodService $foodService;

    public function __construct(FoodService $foodService)
    {
        $this->foodService = $foodService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $foods = Food::with('province')->get();

        return response()->json([
            'status' => true,
            'message' => 'Daftar makanan berhasil diambil',
            'data' => $foods
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFoodRequest $request): JsonResponse
    {
        $food = $this->foodService->store($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Makanan berhasil ditambahkan',
            'data' => $food::with('province')->find($food->id)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $food = Food::with('province')->find($id);

        if (!$food) {
            return response()->json([
                'status' => false,
                'message' => 'Makanan tidak ditemukan',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail makanan berhasil diambil',
            'data' => $food
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFoodRequest $request, int $id): JsonResponse
    {
        try {
            $food = $this->foodService->update($id, $request->validated());

            return response()->json([
                'status' => true,
                'message' => 'Makanan berhasil diperbarui',
                'data' => Food::with('province')->find($food->id)
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Makanan tidak ditemukan',
                'data' => null
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->foodService->delete($id);

        if (!$deleted) {
            return response()->json([
                'status' => false,
                'message' => 'Makanan tidak ditemukan atau gagal dihapus',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Makanan berhasil dihapus',
            'data' => null
        ]);
    }
}
