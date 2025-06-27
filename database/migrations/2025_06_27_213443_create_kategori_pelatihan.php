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
        Schema::create('kategori_pelatihan', function (Blueprint $table) {
            $table->bigIncrements('id_kategori'); // PK
            $table->unsignedBigInteger('id_konsultasi')->nullable();
            $table->enum('jenis_kategori', ['inti', 'pendukung']);
            $table->timestamps();

            $table->foreign('id_konsultasi')->references('id_konsultasi')->on('master_konsultasi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_pelatihan');
    }
};
