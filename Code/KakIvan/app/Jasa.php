<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jasa extends Model
{
    protected $table = 'Jasa';

    protected $guarded = [
        'id'
    ];

    public function order() {
        return $this->belongsToMany(Order::class , 'order_jasa')->withPivot('status_bayar' , 'komisi_jasa');
    }

    public function komisi() {
        return $this->hasMany(Komisi::class);
    }
}