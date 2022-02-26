<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Laravolt\Indonesia\Models\City;

class Kampus extends Model
{
    protected $table = 'data_universitas';

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
