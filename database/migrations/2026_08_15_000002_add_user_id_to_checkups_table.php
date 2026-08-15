<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasColumn('checkups', 'user_id')) {
            Schema::table('checkups', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained()->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('checkups', 'user_id')) {
            Schema::table('checkups', function (Blueprint $table) {
                $table->dropForeignIdFor(\App\Models\User::class);
            });
        }
    }
};
