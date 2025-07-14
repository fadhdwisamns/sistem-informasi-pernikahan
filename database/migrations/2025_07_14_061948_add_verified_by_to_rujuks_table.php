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
        Schema::table('rujuks', function (Blueprint $table) {
            // Tambahkan baris ini. Kolom ini merujuk ke ID dari tabel users.
            $table->foreignId('verified_by')->nullable()->constrained('users')->after('catatan_verifikasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rujuks', function (Blueprint $table) {
            // Ini untuk jaga-jaga jika Anda perlu membatalkan migrasi
            $table->dropForeign(['verified_by']);
            $table->dropColumn('verified_by');
        });
    }
};