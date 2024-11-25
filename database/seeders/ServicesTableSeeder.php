<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesTableSeeder extends Seeder
{
    /**
     * Seed the services table.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $categoryIds = DB::table('service_categories')->pluck('id');

        foreach (range(1, 20) as $index) {
            DB::table('services')->insert([
                'category_id' => $faker->randomElement($categoryIds),
                'name' => $faker->word,
                'description' => $faker->paragraph,
                'duration' => $faker->randomElement(['15', '20', '30', '60']),
                'price' => $faker->randomElement(['30000', '50000', '100000', '200000']),
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ]);
        }
    }
}
