<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_xxxxxx_create_pernikahan_images_table.php
    public function up(): void
    {
        Schema::create('pernikahan_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pernikahan_id')->constrained('pernikahans')->onDelete('cascade');
            $table->string('image_path');
            $table->string('original_name');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pernikahan_images');
    }
};
