<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sopir extends Model
{
    protected $table = 'Sopir';

    protected $guarded = [
        'id'
    ];

    public function order() {
        return $this->belongsToMany(Order::class)->withPivot('validasi');
    }
}