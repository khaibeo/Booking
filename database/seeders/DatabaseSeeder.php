<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            StoreSeeder::class,
            UserSeeder::class,
            ServiceCategoriesTableSeeder::class,
            ServicesTableSeeder::class,
            InvoiceSeeder::class,
            BookingSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
