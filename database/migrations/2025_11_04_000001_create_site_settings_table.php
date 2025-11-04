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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->nullable();
            $table->string('site_tagline')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->text('address')->nullable();
            $table->string('logo')->nullable();
            $table->text('footer_text')->nullable();
            $table->json('social_links')->nullable();
            // SEO / meta
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            // Maintenance and analytics
            $table->boolean('maintenance_mode')->default(false);
            $table->text('analytics_code')->nullable();
            // UI / theme
            $table->string('primary_color')->nullable();
            // Additional editable fields
            $table->text('contact_hours')->nullable();
            $table->string('support_whatsapp')->nullable();
            $table->boolean('enable_registration')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
