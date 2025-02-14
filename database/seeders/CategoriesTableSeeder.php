<?php
namespace Database\Seeders;

use App\Category;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $faker = Fake\Factory::create();
         $categories = [
             "Uncategorized", "Billing/Payments", "Technical question","Technical Issue"
         ];

         foreach($categories as $category)
         {
             Category::create([
                 'name'  => $category,
                 'color' => '#000000'
             ]);
         }
    }
}
