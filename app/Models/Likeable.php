<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Likeable extends Model
{
    protected $guarded = [];

    public function likeable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
