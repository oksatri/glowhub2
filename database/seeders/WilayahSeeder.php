<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class WilayahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * This seeder expects a SQL file at database/sql/wilayah_indonesia_pg.sql
     * which contains the CREATE TABLE and INSERT statements exported from the
     * Wilayah-Administrasi-Indonesia repository.
     */
    public function run(): void
    {
        $path = database_path('sql/wilayah_indonesia_pg.sql');

        if (!File::exists($path)) {
            $this->command->info("Wilayah SQL file not found at {$path}.");
            $this->command->info('Please copy the original SQL file into database/sql/wilayah_indonesia_pg.sql and re-run db:seed --class=WilayahSeeder');
            return;
        }

        $sql = File::get($path);

        // The SQL dump uses backslash-escaped single-quotes like \' inside string literals
        // (e.g. 'Ma\'u'). PostgreSQL expects single quotes to be escaped by doubling them
        // when run via PDO, so convert backslash-escaped single-quotes to SQL-standard ''.
        $sql = str_replace("\\'", "''", $sql);

        DB::beginTransaction();
        try {
            DB::unprepared($sql);
            DB::commit();
            $this->command->info('Wilayah SQL imported successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Failed importing Wilayah SQL: ' . $e->getMessage());
            throw $e;
        }
    }
}
