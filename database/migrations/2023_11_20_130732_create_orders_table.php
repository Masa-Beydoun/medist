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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pharmacist_id');
            $table->date('delivered_at')->nullable();
            $table->enum('status', ['Rejected', 'Pending', 'Preparing', 'On The Way', 'Delivered'])->default('Pending');
            $table->boolean('payment_status')->default(false);
            $table->boolean('is_accepted')->default(false);
            $table->double('bill')->nullable();
            $table->foreignId('warehouse_id')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
