<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kamar', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_ruangan');
            $table->string('nama_kamar', 100);
            $table->boolean('status')->default(true);
            $table->string('keterangan', 255)->nullable();
            $table->timestamps();

            $table->foreign('id_ruangan')
                ->references('id')
                ->on('ruangan')
                ->restrictOnDelete();
            $table->unique(['id_ruangan', 'nama_kamar']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('kamar');
    }
};
