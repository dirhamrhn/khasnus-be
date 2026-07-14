<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProvinceRequest;
use App\Http\Requests\UpdateProvinceRequest;
use App\Services\ProvinceService;
use App\Models\Province;
use Illuminate\Http\JsonResponse;

class ProvinceController extends Controller
{
    protected ProvinceService $provinceService;

    public function __construct(ProvinceService $provinceService)
    {
        $this->provinceService = $provinceService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $provinces = Province::all();

        return response()->json([
            'status' => true,
            'message' => 'Daftar provinsi berhasil diambil',
            'data' => $provinces
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProvinceRequest $request): JsonResponse
    {
        $province = $this->provinceService->store($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Provinsi berhasil ditambahkan',
            'data' => $province
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $province = Province::find($id);

        if (!$province) {
            return response()->json([
                'status' => false,
                'message' => 'Provinsi tidak ditemukan',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail provinsi berhasil diambil',
            'data' => $province
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProvinceRequest $request, int $id): JsonResponse
    {
        try {
            $province = $this->provinceService->update($id, $request->validated());

            return response()->json([
                'status' => true,
                'message' => 'Provinsi berhasil diperbarui',
                'data' => $province
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Provinsi tidak ditemukan',
                'data' => null
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->provinceService->delete($id);

        if (!$deleted) {
            return response()->json([
                'status' => false,
                'message' => 'Provinsi tidak ditemukan atau gagal dihapus',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Provinsi berhasil dihapus',
            'data' => null
        ]);
    }
}
