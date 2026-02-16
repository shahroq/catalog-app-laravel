<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use Faker\Generator as Faker;
use Illuminate\Database\Connection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Filesystem\Filesystem;

class ReviewSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(
        FileSystem $file,
        Connection $db,
        Faker $faker,
    ): void {
        $data = $file->json('database/data-source.json');
        $items = $data['reviews'] ?? [];

        // seed json data
        foreach ($items as $item) {
            $entity = [
                'product_id' => $item['product_id'],
                'content' => $item['content'],
                'rating' => $item['rating'],
                'status' => $item['status'],
                'created_by' => $item['created_by'],
                'updated_by' => $item['updated_by'],
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // with $db
            // $db->table('reviews')->insert($entity);
            // with Model
            // Review::insert($entity);
        }

        // $product = Product::find(3);

        // with factory
        Review::factory(10)
            // ->for($product)
            ->create();
    }
}
