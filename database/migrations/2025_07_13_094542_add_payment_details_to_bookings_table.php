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
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('bank_name')->nullable()->after('payment_proof');
            $table->string('bank_account_number')->nullable()->after('bank_name');
            $table->string('bank_account_name')->nullable()->after('bank_account_number');
            $table->string('ewallet_type')->nullable()->after('bank_account_name');
            $table->string('ewallet_number')->nullable()->after('ewallet_type');
            $table->string('ewallet_name')->nullable()->after('ewallet_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'bank_name',
                'bank_account_number', 
                'bank_account_name',
                'ewallet_type',
                'ewallet_number',
                'ewallet_name'
            ]);
        });
    }
};
