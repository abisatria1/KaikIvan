<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJasaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jasa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_jasa');
            $table->char('notelp_jasa' , 15);
            $table->text('alamat_jasa')->nullable();
            $table->text('keterangan_jasa')->nullable();
            $table->string('status_jasa');
            $table->string('norek_jasa')->nullable();
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
        Schema::dropIfExists('jasa');
    }
}