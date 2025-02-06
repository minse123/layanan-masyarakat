<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Tabel master_konsultasi
        Schema::create('master_konsultasi', function (Blueprint $table) {
            $table->id('id_konsultasi');
            $table->string('nama')->nullable();
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->string('judul_konsultasi');
            $table->text('deskripsi');
            $table->enum('status', ['Pending', 'Dijawab'])->default('Pending');
            $table->timestamps();
        });

        // Tabel konsultasi_pending
        Schema::create('konsultasi_pending', function (Blueprint $table) {
            $table->id('id_pending');
            $table->unsignedBigInteger('id_konsultasi');
            $table->foreign('id_konsultasi')->references('id_konsultasi')->on('master_konsultasi')->onDelete('cascade');
            $table->date('tanggal_pengajuan');
            $table->timestamps();
        });

        // Tabel konsultasi_dijawab
        Schema::create('konsultasi_dijawab', function (Blueprint $table) {
            $table->id('id_dijawab');
            $table->unsignedBigInteger('id_konsultasi');
            $table->foreign('id_konsultasi')->references('id_konsultasi')->on('master_konsultasi')->onDelete('cascade');
            $table->text('jawaban');
            $table->date('tanggal_dijawab');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('konsultasi_dijawab');
        Schema::dropIfExists('konsultasi_pending');
        Schema::dropIfExists('master_konsultasi');
    }
};
