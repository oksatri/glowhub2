<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mua_id')->constrained('muas')->cascadeOnDelete();
            $table->foreignId('mua_service_id')->nullable()->constrained('mua_services')->nullOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('users')->nullOnDelete();

            // guest info (if customer_id is null)
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_whatsapp')->nullable();
            $table->text('customer_address')->nullable();

            $table->decimal('distance_km', 8, 2)->nullable();
            $table->date('selected_date');
            $table->string('selected_time')->nullable();
            $table->json('services')->nullable();

            $table->enum('status', ['pending', 'confirmed', 'rejected', 'completed'])->default('pending');
            $table->text('admin_note')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};
