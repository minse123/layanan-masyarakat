<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('master_surat', function (Blueprint $table) {
            $table->id('id_surat');
            $table->unsignedBigInteger('id_user')->nullable();
            $table->string('nomor_surat')->unique();
            $table->date('tanggal_surat');
            $table->text('perihal');
            $table->string('pengirim');
            $table->enum('status', ['Proses', 'Terima', 'Tolak']);
            $table->text('keterangan')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_surat');
    }
};
