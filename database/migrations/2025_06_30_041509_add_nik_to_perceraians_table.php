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
            $table->string('nik_penggugat', 16)->nullable()->after('nama_penggugat');
            $table->string('nik_tergugat', 16)->nullable()->after('nama_tergugat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perceraians', function (Blueprint $table) {
            $table->dropColumn(['nik_penggugat', 'nik_tergugat']);
        });
    }
};