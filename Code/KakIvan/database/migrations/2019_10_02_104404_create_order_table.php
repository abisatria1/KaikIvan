<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->smallInteger('jumlah_order')->default(1);
            $table->time('jam_order');
            $table->string('status_order');
            $table->Integer('harga_order');
            $table->text('keterangan_order')->nullable();
            $table->date('tanggal_cek')->nullable();
            //foreign
            $table->unsignedBigInteger('manager_id');
            $table->foreign('manager_id')->references('id')->on('manager')->onDelete('cascade');
            //
            
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
        Schema::dropIfExists('order');
    }
}