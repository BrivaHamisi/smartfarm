<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('checkups', function (Blueprint $table) {
            if (! Schema::hasColumn('checkups', 'reminder_sent')) {
                $table->boolean('reminder_sent')->default(false)->after('is_completed');
            }
        });

        Schema::table('inseminations', function (Blueprint $table) {
            if (! Schema::hasColumn('inseminations', 'reminder_sent')) {
                $table->boolean('reminder_sent')->default(false)->after('expected_dob');
            }
        });
    }

    public function down(): void
    {
        Schema::table('checkups', function (Blueprint $table) {
            if (Schema::hasColumn('checkups', 'reminder_sent')) {
                $table->dropColumn('reminder_sent');
            }
        });

        Schema::table('inseminations', function (Blueprint $table) {
            if (Schema::hasColumn('inseminations', 'reminder_sent')) {
                $table->dropColumn('reminder_sent');
            }
        });
    }
};
