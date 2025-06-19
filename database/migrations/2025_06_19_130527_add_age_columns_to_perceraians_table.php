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
        Schema::table('perceraians', function (Blueprint $table) {
            // Tambahkan kolom setelah kolom 'nama_tergugat' atau sesuaikan posisinya
            $table->date('tanggal_lahir_penggugat')->nullable()->after('nama_penggugat');
            $table->date('tanggal_lahir_tergugat')->nullable()->after('nama_tergugat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perceraians', function (Blueprint $table) {
            $table->dropColumn(['tanggal_lahir_penggugat', 'tanggal_lahir_tergugat']);
        });
    }
};