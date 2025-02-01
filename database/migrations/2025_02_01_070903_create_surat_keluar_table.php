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
        Schema::create('surat_keluar', function (Blueprint $table) {
            $table->id('id_keluar');
            $table->foreignId('id_surat');
            $table->date('tanggal_kirim');
            $table->string('penerima');
            $table->text('catatan_kirim')->nullable();
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
        Schema::dropIfExists('surat_keluar');
    }
};
