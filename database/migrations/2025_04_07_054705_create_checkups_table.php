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
        Schema::create('checkups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cow_id')->constrained('cattle')->onDelete('cascade');
            $table->date('date');
            $table->enum('type', ['deworming', 'health_check']);
            $table->boolean('is_completed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkups');
    }
};
