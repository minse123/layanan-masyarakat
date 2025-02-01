<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->id('id_masuk');
            $table->unsignedBigInteger('id_surat'); // Kolom foreign key
            $table->date('tanggal_terima');
            $table->text('disposisi')->nullable();
            $table->timestamps();

            // Definisikan foreign key
            $table->foreign('id_surat')
                ->references('id_surat')
                ->on('master_surat')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_masuk');
    }
};
