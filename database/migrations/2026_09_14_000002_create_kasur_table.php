<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kasur', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_kamar');
            $table->string('kode_kasur', 100);
            $table->boolean('status')->default(true);
            $table->string('status_operasional', 20)->default('available');
            $table->string('keterangan', 255)->nullable();
            $table->timestamps();

            $table->foreign('id_kamar')
                ->references('id')
                ->on('kamar')
                ->restrictOnDelete();
            $table->unique(['id_kamar', 'kode_kasur']);
            $table->index('status_operasional');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kasur');
    }
};
