<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('milk_productions', 'user_id')) {
            Schema::table('milk_productions', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            });
        }

        if (!Schema::hasColumn('inseminations', 'user_id')) {
            Schema::table('inseminations', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('milk_productions', 'user_id')) {
            Schema::table('milk_productions', function (Blueprint $table) {
                $table->dropForeignIdFor(\App\Models\User::class);
            });
        }

        if (Schema::hasColumn('inseminations', 'user_id')) {
            Schema::table('inseminations', function (Blueprint $table) {
                $table->dropForeignIdFor(\App\Models\User::class);
            });
        }
    }
};