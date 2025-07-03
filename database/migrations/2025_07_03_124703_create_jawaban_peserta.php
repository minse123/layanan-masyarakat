<?php

// database/migrations/xxxx_xx_xx_create_jawaban_peserta_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jawaban_peserta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_soal')->constrained('soal_pelatihan')->onDelete('cascade');
            $table->enum('jawaban_peserta', ['a', 'b', 'c', 'd']);
            $table->boolean('benar');
            $table->timestamps();

            $table->unique(['id_user', 'id_soal']); // satu kali jawab per soal
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jawaban_peserta');
    }
};
