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
        Schema::create('package_images', function (Blueprint $table) {
            $table->id('image_id');
            $table->string('image_path');
            $table->string('alt_text')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();

            $table->foreignId('package_id')->constrained('tour_packages', 'id')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_images');
    }
};
