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
        Schema::create('perceraians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pa_id')->constrained('master_pa');
            $table->string('no_putusan')->unique();
            $table->date('tanggal_putusan');
            $table->string('nama_penggugat');
            $table->string('nama_tergugat');
            
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
        Schema::dropIfExists('perceraians');
    }
};
