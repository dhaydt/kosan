<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Apply extends Model
{
    protected $fillable = ['job_status'];

    public function job()
    {
        return $this->belongsTo(Jobs::class, 'job_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
