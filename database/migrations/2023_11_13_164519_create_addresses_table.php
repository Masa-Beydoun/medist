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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('city',['Damascus', 'Homs', 'Aleppo', 'Tartus', 'Hama', 'Rif-Dimashq', 'Latakia', 'Quneitra', 'Daraa', 'Al-Suwayda', 'Deir Ez-Zor', 'Al-Raqqa', 'Al-Hasaka', 'Idlib']);
            $table->string('region');
            $table->string('street');
            $table->morphs('address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
