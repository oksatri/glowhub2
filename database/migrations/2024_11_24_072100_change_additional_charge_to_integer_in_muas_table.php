<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE muas ALTER COLUMN additional_charge TYPE BIGINT USING (additional_charge::BIGINT)');
    }

    public function down()
    {
        DB::statement('ALTER TABLE muas ALTER COLUMN additional_charge TYPE NUMERIC(10,2) USING (additional_charge::NUMERIC(10,2))');
    }
};
