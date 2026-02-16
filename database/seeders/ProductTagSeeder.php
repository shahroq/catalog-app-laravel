<?php

namespace Database\Seeders;

use Database\Factories\ProductTagFactory;
use Illuminate\Database\Connection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductTagSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(Connection $db): void
    {
        // without model
        $tags = ProductTagFactory::new()->count(25)->make()->toArray();
        $db->table('product_tag')->insert($tags);
    }
}
