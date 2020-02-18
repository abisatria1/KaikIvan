<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderPelangganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_pelanggan', function (Blueprint $table) {
            $table->date('tanggal_order');
            //foreign
            $table->unsignedBigInteger('pelanggan_id');
            $table->unsignedBigInteger('order_id');

            $table->foreign('pelanggan_id')->references('id')->on('pelanggan')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('order')->onDelete('cascade');
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
        Schema::dropIfExists('order_pelanggan');
    }
}