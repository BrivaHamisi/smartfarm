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
        Schema::create('calves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cow_id')->constrained('cattle')->onDelete('cascade');
            $table->string('name');
            $table->date('dob');
            $table->decimal('weight_kg', 8, 2);
            $table->string('breed');
            $table->enum('gender', ['male', 'female']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calves');
    }
};
