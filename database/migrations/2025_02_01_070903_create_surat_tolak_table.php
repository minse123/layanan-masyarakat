<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('surat_tolak', function (Blueprint $table) {
            $table->id('id_tolak');
            $table->unsignedBigInteger('id_surat');
            $table->unsignedBigInteger('id_proses');
            $table->date('tanggal_tolak');
            $table->text('alasan_tolak')->nullable();
            $table->timestamps();

            $table->foreign('id_surat')
                ->references('id_surat')
                ->on('master_surat')
                ->onDelete('cascade');

            $table->foreign('id_proses')
                ->references('id_proses')
                ->on('surat_proses')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keluar');
    }
};
