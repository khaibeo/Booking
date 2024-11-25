<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $numberOfStores = 10;
        DB::table('stores')->insert(
            array_map(function () {
                return [
                    'name' => fake()->company,
                    'code' => strtoupper(substr(bin2hex(random_bytes(3)), 0, 8)),
                    'address' => fake()->address,
                    'link_map' => fake()->url,
                    'phone' => $this->generateVietnamesePhoneNumber(),
                    'description' => fake()->text(200),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, range(1, $numberOfStores))
        );
    }

    /**
     * Generate a fake Vietnamese phone number.
     *
     * @return string
     */
    private function generateVietnamesePhoneNumber()
    {
        $prefixes = ['09', '08', '07', '03']; // Các mã vùng phổ biến ở Việt Nam
        $prefix = $prefixes[array_rand($prefixes)]; // Chọn một mã vùng ngẫu nhiên
        $number = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT); // Tạo số điện thoại 8 chữ số

        return $prefix.$number; // Kết hợp mã vùng và số điện thoại

    }
}
