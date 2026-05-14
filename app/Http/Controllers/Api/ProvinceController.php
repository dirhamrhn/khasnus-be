<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    //semua provensi
    public function index()
    {
        return response()->json(
            Province::all()
        );
    }

    //detail provinsi
    public function show($id)
    {
        $province = Province::with('foods')->find($id);
        if (!$province) {
            return response()->json([
                'message' => 'Provinsi tidak ditemukan'
            ], 404);
        }

        return response()->json($province);
    }
    //search provensi
    public function search(Request $request)
    {
        $query = $request->query('query');
        $provinces = Province::where('name', 'like', "%{$query}%")
            ->orWhere('alternate_name', 'like', "%{$query}%")
            ->get();
        return response()->json($provinces);
    }
}
