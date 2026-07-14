<?php

namespace App\Services;

use App\Models\Food;

class FoodService
{
    public function store($data)
    {
        return Food::create($data);
    }

    public function update($id, $data)
    {
        $food = Food::findOrFail($id);
        $food->update($data);

        return $food;
    }

    public function delete($id)
    {
        return Food::destroy($id);
    }
}
