<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFoodRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'province_id' => 'sometimes|exists:provinces,id',
            'name' => 'sometimes|string|max:150',
            'description' => 'sometimes|string',
            'description_en' => 'nullable|string',
            'ingredients' => 'sometimes|string',
            'ingredients_en' => 'nullable|string',
            'recipe' => 'sometimes|string',
            'recipe_en' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'youtube_link' => 'nullable|string|max:255',
        ];
    }
}
