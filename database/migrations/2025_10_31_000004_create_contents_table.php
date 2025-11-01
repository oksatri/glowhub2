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
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('section_type', ['product', 'testimonials', 'contact', 'content', 'hero'])->default('content');
            $table->boolean('has_button')->default(false);
            $table->unsignedSmallInteger('buttons_count')->default(0);
            $table->json('buttons')->nullable()->comment('JSON array for button texts/links');
            $table->string('image')->nullable();
            $table->enum('status', ['publish', 'archive', 'draft'])->default('draft');
            $table->integer('order')->default(0)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
