<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Apply extends Model
{
    public function job()
    {
        return $this->belongsTo(Jobs::class, 'job_id');
    }
}
