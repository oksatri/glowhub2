<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mua_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mua_id')->constrained('muas')->onDelete('cascade');
            $table->string('service_name');
            $table->text('description')->nullable();
            $table->json('features')->nullable();
            $table->unsignedInteger('price')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mua_services');
    }
};
