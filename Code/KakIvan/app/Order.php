<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    protected $guarded = ['id'];



    public function pelanggan() {
        return $this->belongsToMany(Pelanggan::class)->withPivot('tanggal_order');
    }

    public function sopir() {
        return $this->belongsToMany(Sopir::class)->withPivot('validasi');
    }

    public function jasa() {
        return $this->belongsToMany(Jasa::class , 'order_jasa')->withPivot('status_bayar' , 'komisi_jasa');
    }
    
}