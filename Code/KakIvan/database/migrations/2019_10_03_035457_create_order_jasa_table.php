<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderJasaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_jasa', function (Blueprint $table) {
            //foreign
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('jasa_id');
            $table->smallInteger('status_bayar')->default(0);
            $table->unsignedBigInteger('komisi_jasa');
            $table->foreign('order_id')->references('id')->on('order')->primary()->onDelete('cascade');
            $table->foreign('jasa_id')->references('id')->on('jasa')->primary()->onDelete('cascade');
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
        Schema::dropIfExists('order_jasa');
    }
}