<?php

namespace Database\Seeders;

use App\Models\Product;
use Faker\Generator as Faker;
use Illuminate\Database\Connection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Filesystem\Filesystem;

class ProductSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(FileSystem $file,
        Connection $db,
        Faker $faker,
    ): void {
        $path = database_path('data-source.json');
        $data = $file->json($path);
        $items = $data['products'] ?? [];

        // seed json data
        foreach ($items as $item) {
            $entity = [
                'name' => $item['name'],
                'description' => $item['description'],
                'price' => $item['price'],
                // 'price' => $faker->randomFloat(2, 10, 500),
                'category' => $item['category'],
                'in_stock' => $item['in_stock'],
                'created_by' => $item['created_by'],
                'updated_by' => $item['updated_by'],
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // with $db
            // $db->table('products')->insert($entity);
            // with Model
            // Product::insert($entity);
        }

        // with factory
        Product::factory(5)->create();
    }
}
