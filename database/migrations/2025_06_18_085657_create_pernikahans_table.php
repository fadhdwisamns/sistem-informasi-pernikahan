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
        Schema::create('pernikahans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kua_id')->constrained('master_kua');
            $table->enum('jenis_data', ['pernikahan', 'rujuk']);
            $table->string('no_akta')->unique();
            $table->date('tanggal_akad');
            
            // Detail Suami
            $table->string('nama_suami');
            $table->string('nik_suami', 16);
            $table->string('tempat_lahir_suami');
            $table->date('tanggal_lahir_suami');

            // Detail Istri
            $table->string('nama_istri');
            $table->string('nik_istri', 16);
            $table->string('tempat_lahir_istri');
            $table->date('tanggal_lahir_istri');
            
            // Status & Verifikasi
            $table->enum('status_verifikasi', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
            $table->text('catatan_verifikasi')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pernikahans');
    }
};
