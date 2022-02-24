<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Province;

class AddressController extends Controller
{
    public function province()
    {
        $prov = Province::pluck('name', 'id');

        return $prov;
    }

    public function city($id)
    {
        if ($id == 'all') {
            $city = City::pluck('name', 'id');
        } else {
            $city = City::where('province_id', $id)->pluck('name', 'id');
        }

        return $city;
    }

    public function district($id)
    {
        if ($id == 'all') {
            $district = District::pluck('name', 'id');
        } else {
            $district = District::where('city_id', $id)->pluck('name', 'id');
        }

        return $district;
    }
}
