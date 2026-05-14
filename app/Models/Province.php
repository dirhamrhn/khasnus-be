<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $fillable = [
        'name',
        'alternate_name',
        'image'
    ];

    public function foods()
    {
        return $this->hasMany(Food::class);
    }
}