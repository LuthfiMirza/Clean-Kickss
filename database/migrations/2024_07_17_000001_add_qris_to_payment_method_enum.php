<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For MySQL, we need to use raw SQL to modify ENUM
        DB::statement("ALTER TABLE bookings MODIFY COLUMN payment_method ENUM('cash', 'transfer', 'e_wallet', 'qris', 'credit_card') NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original ENUM values
        DB::statement("ALTER TABLE bookings MODIFY COLUMN payment_method ENUM('cash', 'transfer', 'e_wallet', 'credit_card') NULL");
    }
};