<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create a test user
        User::factory()->create([
            'name' => 'Livingstone Apeli',
            'email' => 'livingstoneapeli@gmail.com',
        ]);

        // Create some test clients and templates if needed
        $this->call([
            ClientSeeder::class,
            EmailTemplateSeeder::class,
        ]);
    }
}
