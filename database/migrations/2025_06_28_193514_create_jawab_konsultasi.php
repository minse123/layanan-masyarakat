<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jawab_konsultasi', function (Blueprint $table) {
            $table->id('id_jawab');
            $table->unsignedBigInteger('id_konsultasi');
            $table->text('jawaban');
            $table->timestamp('tanggal_dijawab')->nullable();
            $table->timestamps();

            $table->foreign('id_konsultasi')
                ->references('id_konsultasi')
                ->on('master_konsultasi')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawab_konsultasi');
    }
};
