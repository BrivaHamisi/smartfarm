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
        Schema::create('inseminations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cow_id')->constrained('cattle')->onDelete('cascade');
            $table->date('date');
            $table->string('bull_number');
            $table->boolean('successful')->nullable();
            $table->date('expected_dob')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inseminations');
    }
};
