<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;

class Jobs extends Model
{
    public function cities()
    {
        return $this->belongsTo(City::class, 'city', 'name');
    }

    public function dis()
    {
        return $this->belongsTo(District::class, 'district', 'name');
    }
}
