<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductTag;
use App\Models\Review;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->cleanData();

        // User::factory()->create(['name' => 'Mr. Admin', 'email' => 'admin@example.com', 'role' => 'ADMIN']);
        User::factory()->createMany([
            ['name' => 'Mr. Admin', 'email' => 'admin@example.com', 'role' => 'ADMIN'],
            ['name' => 'Miss. Editor', 'email' => 'editor@example.com', 'role' => 'EDITOR'],
        ]);
        User::factory(5)->create();

        $tags = Tag::factory(10)->create();
        $products = Product::factory(5)->recycle($tags)->create();
        Review::factory(10)->recycle($products)->create();
        // TODO: use recycle?
        ProductTag::factory(25)->create();

        // call separate seeders' files
        /*
        $this->call([
            ProductSeeder::class,
            ReviewSeeder::class,
            TagSeeder::class,
            ProductTagSeeder::class,
        ]);
        */

    }

    private function cleanData()
    {
        // DB::statement('SET FOREIGN_KEY_CHECKS=0'); // only mysql
        DB::table('users')->truncate();
        DB::table('products')->truncate();
        DB::table('reviews')->truncate();
        DB::table('tags')->truncate();
        DB::table('product_tag')->truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
