<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'test@example.com')->first();
        
        if ($user) {
            $clients = [
                ['name' => 'John Doe', 'email' => 'john@example.com', 'phone' => '+1-234-567-8901'],
                ['name' => 'Jane Smith', 'email' => 'jane@example.com', 'phone' => '+1-234-567-8902'],
                ['name' => 'Bob Johnson', 'email' => 'bob@example.com', 'phone' => '+1-234-567-8903'],
                ['name' => 'Alice Williams', 'email' => 'alice@example.com', 'phone' => null],
                ['name' => 'Charlie Brown', 'email' => 'charlie@example.com', 'phone' => '+1-234-567-8905'],
            ];

            foreach ($clients as $clientData) {
                $user->clients()->create($clientData);
            }
        }
    }
}