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
        Schema::create('jadwal_pelatihan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelatihan');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();
            $table->string('lokasi')->nullable();
            $table->text('deskripsi')->nullable();
            $table->enum('pelatihan_inti', [
                'bumdes',
                'kpmd',
                'masyarakat_hukum_adat',
                'pembangunan_desa_wisata',
                'catrans',
                'pelatihan_perencanaan_pembangunan_partisipatif'
            ])->nullable();
            $table->enum('pelatihan_pendukung', [
                'prukades',
                'prudes',
                'ecomerce'
            ])->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_pelatihan');
    }
};
