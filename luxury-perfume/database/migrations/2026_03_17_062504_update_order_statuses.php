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
        // Change the default value of the status column
        Schema::table('orders', function (Blueprint $table) {
            $table->string('status')->default('Order Placed')->change();
        });
        
        // Update existing 'pending' orders to 'Order Placed'
        DB::table('orders')->where('status', 'pending')->update(['status' => 'Order Placed']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('status')->default('pending')->change();
        });
    }
};
