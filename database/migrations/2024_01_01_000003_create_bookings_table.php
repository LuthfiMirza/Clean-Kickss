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
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->date('booking_date');
            $table->datetime('pickup_time');
            $table->datetime('delivery_time')->nullable();
            $table->enum('status', [
                'pending',
                'confirmed',
                'picked_up',
                'in_progress',
                'ready',
                'delivered',
                'cancelled'
            ])->default('pending');
            $table->text('notes')->nullable();
            $table->decimal('total_price', 10, 2);
            $table->enum('payment_status', ['pending', 'paid', 'refunded'])->default('pending');
            $table->enum('payment_method', ['cash', 'transfer', 'e_wallet', 'credit_card'])->nullable();
            $table->timestamps();
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