<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFoodRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'province_id' => 'required|exists:provinces,id',
            'name' => 'required|string|max:150',
            'description' => 'required|string',
            'description_en' => 'nullable|string',
            'ingredients' => 'required|string',
            'ingredients_en' => 'nullable|string',
            'recipe' => 'required|string',
            'recipe_en' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'youtube_link' => 'nullable|string|max:255',
        ];
    }
}
