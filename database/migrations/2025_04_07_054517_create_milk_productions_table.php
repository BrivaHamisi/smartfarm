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
        Schema::create('milk_productions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cow_id')->constrained('cattle')->onDelete('cascade');
            $table->decimal('morning', 8, 2);
            $table->decimal('afternoon', 8, 2);
            $table->decimal('evening', 8, 2);
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('milk_productions');
    }
};
