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
           

            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('catatan_verifikasi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rujuks', function (Blueprint $table) {
            // Hapus foreign key constraint sebelum drop kolom
            $table->dropForeign(['verified_by']);
            $table->dropColumn(['verified_by', 'catatan_verifikasi']);
        });
    }
};