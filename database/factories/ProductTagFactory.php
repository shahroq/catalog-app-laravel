<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductTag>
 */
class ProductTagFactory extends Factory
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

        $productIds = Product::pluck('id')->toArray();
        $tagIds = Tag::pluck('id')->toArray();

        return [
            'product_id' => $faker->randomElement($productIds),
            'tag_id' => $faker->randomElement($tagIds),
        ];
    }
}
