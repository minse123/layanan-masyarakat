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
        Schema::create('jenis_pelatihan', function (Blueprint $table) {
            $table->bigIncrements('id_pelatihan'); // PK
            $table->unsignedBigInteger('id_kategori')->nullable(); // FK
            $table->enum('pelatihan_inti', [
                'bumdes',
                'kpmd',
                'masyarakat_hukum_adat',
                'pembangunan_desa_wisata',
                'catrans',
                'pelatihan_perencanaan_pembangunan_partisipatif'
            ])->nullable();
            $table->date('tanggal_pengajuan');
            $table->enum('pelatihan_pendukung', [
                'prukades',
                'prudes',
                'ecomerce'
            ])->nullable();
            $table->timestamps();

            $table->foreign('id_kategori')->references('id_kategori')->on('kategori_pelatihan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_pelatihan');
    }
};
