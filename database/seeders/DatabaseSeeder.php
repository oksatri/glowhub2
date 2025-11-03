<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\ContentSeeder;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(AdminUserSeeder::class);
        // Seed front content sections and their details to match the current front layout
        $this->call(ContentSeeder::class);
        // Testimonials shown on the front page
        $this->call(TestimonialSeeder::class);
    }
}
