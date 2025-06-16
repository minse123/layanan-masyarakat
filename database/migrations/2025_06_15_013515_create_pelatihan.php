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
        Schema::create('pelatihan', function (Blueprint $table) {
            $table->id('id_pelatihan');
            $table->unsignedBigInteger('id_kategori_pelatihan')->nullable();
            $table->enum('pelatihan_inti', ['bumdesa', 'kpmd', 'masyarakat_hukum_adat', 'pembangunan_desa_wisata', 'catrans', 'pelatihan_perencanaan_pembangunan_partisipatif']);
            $table->enum('pelatihan_pendukung', ['prukades', 'prudes', 'ecomerce']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelatihan');
    }
};
