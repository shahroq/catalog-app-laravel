<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
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

        // TODO: better solution?
        $productIds = Product::pluck('id')->toArray();

        return [
            // 'product_id' => $faker->randomElement($productIds),
            'product_id' => Product::factory(),
            'content' => $faker->sentence(5),
            'rating' => $faker->numberBetween(1, 6),
            'status' => $faker->randomElement(['PENDING', 'REJECTED', 'APPROVED']),
            'created_by' => 1,
            'updated_by' => 1,
            // 'created_at' => now(),
            // 'updated_at' => now(),
        ];
    }
}
