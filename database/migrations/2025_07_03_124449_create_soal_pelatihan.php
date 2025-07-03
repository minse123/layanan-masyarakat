<?php

// database/migrations/xxxx_xx_xx_create_soal_pelatihan_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('soal_pelatihan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kategori_soal_pelatihan')->constrained('kategori_soal_pelatihan')->onDelete('cascade');
            $table->text('pertanyaan');
            $table->string('pilihan_a');
            $table->string('pilihan_b');
            $table->string('pilihan_c');
            $table->string('pilihan_d');
            $table->enum('jawaban_benar', ['a', 'b', 'c', 'd']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('soal_pelatihan');
    }
};
