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
        Schema::create('content_details', function (Blueprint $table) {
            $table->id();
            $table->string('category')->nullable()->comment('e.g. card, about');
            $table->foreignId('content_id')->constrained('contents')->onDelete('cascade');
            $table->string('icon')->nullable();
            $table->string('image')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->json('additional')->nullable()->comment('extra structured data');
            $table->integer('order')->default(0)->index();
            $table->boolean('has_button')->default(false);
            $table->unsignedSmallInteger('buttons_count')->default(0);
            $table->json('buttons')->nullable()->comment('JSON array for button texts/links');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_details');
    }
};
