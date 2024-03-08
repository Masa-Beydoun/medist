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
        Schema::create('medicine_details', function (Blueprint $table) {
            $table->id();
            $table->string('dose');
            $table->enum('type',['Syrup', 'Injection', 'Tablet', 'Ointment']);
            $table->integer('price');
            $table->date('expiry_date');
            $table->boolean('is_expired')->default(false);
            $table->integer('expired_price')->default(0);
            $table->foreignId('medicine_id')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicine_details');
    }
};
