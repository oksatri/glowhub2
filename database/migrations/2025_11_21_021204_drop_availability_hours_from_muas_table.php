<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('muas', function (Blueprint $table) {
            if (Schema::hasColumn('muas', 'availability_hours')) {
                $table->dropColumn('availability_hours');
            }
        });
    }

    public function down()
    {
        Schema::table('muas', function (Blueprint $table) {
            $table->string('availability_hours')->nullable();
        });
    }
};
