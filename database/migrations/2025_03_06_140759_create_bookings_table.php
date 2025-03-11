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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->date('booking_date');
            $table->date('travel_date');
            $table->integer('number_of_travelers');
            $table->decimal('total_amount', 10, 2);
            $table->enum('payment_status', ['pending', 'partial', 'paid', 'refunded'])->default('pending');
            $table->enum('booking_status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->text('special_requests')->nullable();
            $table->timestamps();

            $table->foreignId('package_id')->constrained('tour_packages', 'id')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
