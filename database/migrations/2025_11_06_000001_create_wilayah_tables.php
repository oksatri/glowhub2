<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates reg_provinces, reg_regencies, reg_districts and reg_villages tables.
     */
    public function up()
    {
        // Create tables only if they don't already exist. This makes the migration
        // safe to run on databases where the tables may have been created earlier.
        if (!Schema::hasTable('reg_provinces')) {
            Schema::create('reg_provinces', function (Blueprint $table) {
                // province id is 2 chars (e.g. '11')
                $table->char('id', 2)->primary();
                $table->string('name');
            });
        }

        if (!Schema::hasTable('reg_regencies')) {
            Schema::create('reg_regencies', function (Blueprint $table) {
                // regency id is 4 chars (e.g. '1101')
                $table->char('id', 4)->primary();
                $table->char('province_id', 2);
                $table->string('name');
                $table->foreign('province_id')->references('id')->on('reg_provinces')->onDelete('cascade');
            });
        }

        if (!Schema::hasTable('reg_districts')) {
            Schema::create('reg_districts', function (Blueprint $table) {
                // district id is 6 chars (e.g. '110101')
                $table->char('id', 6)->primary();
                $table->char('regency_id', 4);
                $table->string('name');
                $table->foreign('regency_id')->references('id')->on('reg_regencies')->onDelete('cascade');
            });
        }

        if (!Schema::hasTable('reg_villages')) {
            Schema::create('reg_villages', function (Blueprint $table) {
                // village id is 10 chars (e.g. '1101012001')
                $table->char('id', 10)->primary();
                $table->char('district_id', 6);
                $table->string('name');
                $table->foreign('district_id')->references('id')->on('reg_districts')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('reg_villages');
        Schema::dropIfExists('reg_districts');
        Schema::dropIfExists('reg_regencies');
        Schema::dropIfExists('reg_provinces');
    }
};
