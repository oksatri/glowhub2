<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('muas', function (Blueprint $table) {
            $table->text('service_cities')->nullable()->after('city');
        });
    }

    public function down()
    {
        Schema::table('muas', function (Blueprint $table) {
            $table->dropColumn('service_cities');
        });
    }
};
