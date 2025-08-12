<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmailTemplateFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'subject' => $this->faker->sentence(),
            'body' => $this->faker->paragraphs(3, true),
            'placeholders' => ['name', 'email'],
            'user_id' => User::factory(),
        ];
    }
}
