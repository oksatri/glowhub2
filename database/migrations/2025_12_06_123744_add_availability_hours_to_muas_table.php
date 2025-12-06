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
            $table->json('availability_hours')->nullable()->comment('JSON array untuk menyimpan jam tidak tersedia (booking luar platform)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('muas', function (Blueprint $table) {
            $table->dropColumn('availability_hours');
        });
    }
};
