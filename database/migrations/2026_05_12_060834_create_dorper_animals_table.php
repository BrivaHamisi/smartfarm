<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dorper_animals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('tag_number')->unique();
            $table->date('date_of_birth');
            $table->string('breed_lineage');
            $table->enum('gender', ['ewe', 'ram', 'lamb']);
            $table->decimal('weight_kg', 8, 2);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('dorper_breeding_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('ewe_tag');
            $table->string('ram_tag');
            $table->date('mating_date');
            $table->date('expected_lambing_date');  // mating_date + 147 days
            $table->date('lambing_date')->nullable();
            $table->integer('lambs_born')->nullable();
            $table->text('remarks')->nullable();
            $table->boolean('reminder_sent')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dorper_breeding_records');
        Schema::dropIfExists('dorper_animals');
    }
};