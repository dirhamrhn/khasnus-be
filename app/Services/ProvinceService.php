<?php

namespace App\Services;

use App\Models\Province;

class ProvinceService
{
    public function store($data)
    {
        return Province::create($data);
    }

    public function update($id, $data)
    {
        $province = Province::findOrFail($id);
        $province->update($data);

        return $province;
    }

    public function delete($id)
    {
        return Province::destroy($id);
    }
}