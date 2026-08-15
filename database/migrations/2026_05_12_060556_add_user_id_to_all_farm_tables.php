<?php
// database/migrations/xxxx_add_user_id_to_all_farm_tables.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // $tables = ['cattle', 'calves', 'milk_productions', 'inseminations', 'poultry', 'finances', 'workers'];

        // To this:
        $tables = [ 'workers'];
        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        $tables = ['cattle', 'calves', 'milk_productions', 'inseminations', 'poultry', 'finances', 'workers'];
        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $blueprint) use ($table) {
                $blueprint->dropForeignIdFor(\App\Models\User::class);
            });
        }
    }
};
