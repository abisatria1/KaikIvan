<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Komisi extends Model
{
    protected $table = 'komisi';
    protected $guarded = ['id'];

    public function jasa () {
        return $this->belongsTo(Jasa::class);
    }
}