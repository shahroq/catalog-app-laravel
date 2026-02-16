<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        /** @var \Faker\Generator $faker */
        $faker = fake();

        return [
            'name' => $faker->words(1, true),
            'description' => $faker->sentence(5),
            'price' => $faker->randomFloat(2, 10, 500),
            'category' => $faker->words(2, true),
            'in_stock' => $faker->boolean(75),
            'created_by' => 1,
            'updated_by' => 1,
            // 'created_at' => now(),
            // 'updated_at' => now(),
        ];
    }
}
