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
        Schema::create('destination_images', function (Blueprint $table) {
            $table->id();
            $table->string('image_path');
            $table->string('alt_text')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();

            $table->foreignId('destination_id')->constrained('destinations', 'id')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destination_images');
    }
};
