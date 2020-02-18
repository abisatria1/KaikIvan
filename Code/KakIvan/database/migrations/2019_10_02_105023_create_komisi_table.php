<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKomisiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('komisi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('tanggal_pembayaran');
            $table->bigInteger('jumlah_bayar');
            $table->smallInteger('jumlah_order');
            //foreign
            $table->unsignedBigInteger('jasa_id');
            $table->foreign('jasa_id')->references('id')->on('jasa')->onDelete('cascade');
            $table->timestamps();
        });
 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('komisi');
    }
}