<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UploadController extends Controller
{
    public function uploadImage(Request $request): JsonResponse
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('uploads', 'public');

            return response()->json([
                'status' => true,
                'message' => 'Gambar berhasil diunggah',
                'path' => $path,
                'url' => asset('storage/' . $path)
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Tidak ada file gambar yang dikirim'
        ], 400);
    }
}
