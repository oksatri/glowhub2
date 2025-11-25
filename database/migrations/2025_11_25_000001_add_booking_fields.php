<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->text('mua_note')->nullable()->after('admin_note');
            $table->decimal('revised_price', 12, 2)->nullable()->after('mua_note');
            $table->text('price_note')->nullable()->after('revised_price');
            $table->decimal('service_price', 12, 2)->nullable()->after('price_note');
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['mua_note', 'revised_price', 'price_note', 'service_price']);
        });
    }
};
