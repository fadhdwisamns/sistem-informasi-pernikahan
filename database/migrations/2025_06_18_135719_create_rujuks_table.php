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
        Schema::create('rujuks', function (Blueprint $table) {
            $table->id();
            $table->string('no_surat_rujuk')->unique();
            $table->date('tanggal_rujuk');
            $table->string('nama_suami');
            $table->string('nik_suami');
            $table->string('nama_istri');
            $table->string('nik_istri');
            $table->string('tempat_rujuk');
            $table->enum('status', ['Menunggu', 'Disetujui', 'Ditolak'])->default('Menunggu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rujuks');
    }
};
