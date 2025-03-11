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
        Schema::create('rents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained('cars', 'id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('name');
            $table->string('phone');
            $table->string('type');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('price');
            $table->string('status');
            $table->string('location_pickup');
            $table->string('location_delivery');
            $table->string('payment_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rents');
    }
};
