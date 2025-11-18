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
        Schema::table('mua_services', function (Blueprint $table) {
            if (! Schema::hasColumn('mua_services', 'categori_service')) {
                $table->string('categori_service')->nullable()->after('price');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mua_services', function (Blueprint $table) {
            if (Schema::hasColumn('mua_services', 'categori_service')) {
                $table->dropColumn('categori_service');
            }
        });
    }
};
