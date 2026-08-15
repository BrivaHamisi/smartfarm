<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        $tables = ['cattle', 'calves', 'poultry'];

        foreach ($tables as $table) {
            if (!Schema::hasColumn($table, 'user_id')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
                });
            }
        }
    }

    public function down(): void
    {
        $tables = ['cattle', 'calves', 'poultry'];

        foreach ($tables as $table) {
            if (Schema::hasColumn($table, 'user_id')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->dropForeignIdFor(\App\Models\User::class);
                });
            }
        }
    }
};
