<?php

// database/migrations/xxxx_xx_xx_create_hasil_pelatihan_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hasil_pelatihan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_kategori_soal_pelatihan')->constrained('kategori_soal_pelatihan')->onDelete('cascade');
            $table->unsignedInteger('total_soal');
            $table->unsignedInteger('benar');
            $table->unsignedInteger('salah');
            $table->decimal('nilai', 5, 2); // misal 85.00
            $table->timestamps();

            $table->unique(['id_user', 'id_kategori_soal_pelatihan']); // 1 nilai per user per kategori
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hasil_pelatihan');
    }
};
