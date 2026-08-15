<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rabbits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('rabbit_id')->unique();
            $table->string('breed');
            $table->enum('gender', ['doe', 'buck']);
            $table->timestamps();
        });

        Schema::create('rabbit_breeding_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('doe_id');
            $table->string('buck_id');
            $table->date('mating_date');
            $table->date('expected_kindling_date');  // mating_date + 31 days
            $table->integer('litter_size')->nullable();
            $table->boolean('reminder_sent')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rabbit_breeding_records');
        Schema::dropIfExists('rabbits');
    }
};