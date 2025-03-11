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
        Schema::create('package_destinations', function (Blueprint $table) {
            $table->id();
            $table->integer('day_number');
            $table->text('visit_details')->nullable();
            $table->timestamps();

            $table->foreignId('package_id')->constrained('tour_packages', 'id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('destination_id')->constrained('destinations', 'id')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_destinations');
    }
};
