<?php

namespace Database\Seeders;

use App\Models;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;


class ModelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker    )
    {
    //    $faker = Faker\Factory::create();
       $model = [
        'Gravity Series'
       ];

       foreach($model as $model)
       {
        Models::create([
            'name' => $model,
            'color' => $faker->hexcolor
        ]);
       }
    }
}
