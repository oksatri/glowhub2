<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('muas', function (Blueprint $table) {
            if (Schema::hasColumn('muas', 'specialty')) {
                $table->dropColumn('specialty');
            }
            if (Schema::hasColumn('muas', 'experience')) {
                $table->dropColumn('experience');
            }
            if (!Schema::hasColumn('muas', 'max_distance')) {
                $table->unsignedInteger('max_distance')->nullable()->after('rating');
            }
            if (!Schema::hasColumn('muas', 'operational_hours')) {
                $table->string('operational_hours')->nullable()->after('max_distance');
            }
            if (!Schema::hasColumn('muas', 'additional_charge')) {
                $table->decimal('additional_charge', 10, 2)->default(0)->after('operational_hours');
            }
            if (!Schema::hasColumn('muas', 'availability_hours')) {
                $table->string('availability_hours')->nullable()->after('additional_charge');
            }
        });
    }

    public function down(): void
    {
        Schema::table('muas', function (Blueprint $table) {
            if (!Schema::hasColumn('muas', 'specialty')) {
                $table->string('specialty')->nullable()->after('district');
            }
            if (!Schema::hasColumn('muas', 'experience')) {
                $table->string('experience')->nullable()->after('rating');
            }
            if (Schema::hasColumn('muas', 'max_distance')) {
                $table->dropColumn('max_distance');
            }
            if (Schema::hasColumn('muas', 'operational_hours')) {
                $table->dropColumn('operational_hours');
            }
            if (Schema::hasColumn('muas', 'additional_charge')) {
                $table->dropColumn('additional_charge');
            }
            if (Schema::hasColumn('muas', 'availability_hours')) {
                $table->dropColumn('availability_hours');
            }
        });
    }
};
