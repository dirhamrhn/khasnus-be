<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $table = 'foods';

    public $timestamps = false;

    protected $fillable = [
        'province_id',
        'name',
        'description',
        'description_en',
        'ingredients',
        'ingredients_en',
        'recipe',
        'recipe_en',
        'image',
        'youtube_link'
    ];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}