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
        Schema::table('muas', function (Blueprint $table) {
            if (! Schema::hasColumn('muas', 'link_map')) {
                $table->string('link_map')->nullable()->after('experience');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('muas', function (Blueprint $table) {
            if (Schema::hasColumn('muas', 'link_map')) {
                $table->dropColumn('link_map');
            }
        });
    }
};
