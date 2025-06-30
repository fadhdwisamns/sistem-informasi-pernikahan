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
            $table->string('file_akta_cerai')->nullable()->after('tempat_rujuk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rujuks', function (Blueprint $table) {
            $table->dropColumn('file_akta_cerai');
        });
    }
};