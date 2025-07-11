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
        Schema::create('video_pelatihan', function (Blueprint $table) {
            $table->id();
            $table->string('judul')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('youtube_id', 20);
            $table->string('thumbnail_url')->nullable();
            $table->enum('jenis_pelatihan', ['inti', 'pendukung'])->default('inti'); // Tambahkan ini
            $table->boolean('ditampilkan')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_pelatihan');
    }
};
