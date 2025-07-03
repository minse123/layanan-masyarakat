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
            $table->unsignedBigInteger('id_user')->nullable();
            $table->string('nama');
            $table->string('telepon');
            $table->string('email');
            $table->string('judul_konsultasi');
            $table->text('deskripsi');
            $table->enum('status', ['Pending', 'Dijawab'])->default('Pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('master_konsultasi');
    }
};
