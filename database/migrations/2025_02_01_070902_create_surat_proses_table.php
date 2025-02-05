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
        Schema::create('surat_proses', function (Blueprint $table) {
            $table->id('id_proses');
            $table->unsignedBigInteger('id_surat');
            $table->date('tanggal_proses');
            $table->text('catatan_proses')->nullable();
            $table->timestamps();

            $table->foreign('id_surat')
                ->references('id_surat')
                ->on('master_surat')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_proses');
    }
};
