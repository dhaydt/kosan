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

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    public function dis()
    {
        return $this->belongsTo(District::class, 'district', 'name');
    }

    public function scopeActive($query)
    {
        return $query->where(['status' => 1])->orWhere(function ($query) {
            $query->where(['added_by' => 'admin', 'status' => 1]);
        });
    }
}
