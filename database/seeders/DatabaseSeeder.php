<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Update frontend content and sliders
        $this->call([
            UpdateContentSeeder::class,
            CompleteContentUpdateSeeder::class,
            UpdateBarmaglyContentSeeder::class,
        ]);
    }
}
