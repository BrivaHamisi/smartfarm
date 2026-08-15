<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('crop_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('field_name');
            $table->string('crop_planted');
            $table->decimal('acreage', 8, 2);
            $table->date('planting_date');
            $table->timestamps();
        });

        Schema::create('crop_inputs', function (Blueprint $table) {  // fertilizer & pesticide
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('crop_field_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->enum('type', ['fertilizer', 'pesticide', 'herbicide', 'other']);
            $table->string('brand_name');
            $table->decimal('quantity', 10, 2);
            $table->string('unit')->default('kg');
            $table->timestamps();
        });

        Schema::create('crop_harvests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('crop_field_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->string('crop');
            $table->decimal('quantity_harvested', 10, 2);
            $table->string('unit');  // bags, kg, tonnes
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('crop_harvests');
        Schema::dropIfExists('crop_inputs');
        Schema::dropIfExists('crop_fields');
    }
};