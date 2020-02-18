<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSopirTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sopir', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_sopir');
            $table->text('alamat_sopir')->nullable();
            $table->char('notelp_sopir' , 15);
            $table->text('keterangan_sopir')->nullable();
            $table->char('kode_sopir' , 5);
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
        Schema::dropIfExists('sopir');
    }
}