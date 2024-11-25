<?php

namespace Database\Seeders;

use App\Models\Admin\Store;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $listUsers = [];
        $numberOfStores = Store::query()->count();

        for ($storeId = 1; $storeId <= $numberOfStores; $storeId++) {
            // Tạo 1 quản lý cho mỗi cửa hàng
            $listUsers[] = [
                'store_id' => $storeId,
                'name' => 'manager'.$storeId,
                'email' => 'manager'.$storeId.'@gmail.com',
                'password' => Hash::make('12345678'),
                'phone' => '09'.rand(10000000, 99999999),
                'role' => 'manager',
                'expired' => rand(1, 3),
                'biography' => fake()->paragraph(2),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Tạo 10 nhân viên cho mỗi cửa hàng
            for ($i = 1; $i <= 10; $i++) {
                $listUsers[] = [
                    'store_id' => $storeId,
                    'name' => 'staff'.$storeId.'_'.$i,
                    'email' => 'staff'.$storeId.'_'.$i.'@gmail.com',
                    'password' => Hash::make('12345678'),
                    'phone' => '09'.rand(10000000, 99999999),
                    'role' => 'staff',
                    'expired' => rand(1, 3),
                    'biography' => fake()->paragraph(2),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Tạo 2 thu ngân cho mỗi cửa hàng
            for ($i = 1; $i <= 2; $i++) {
                $listUsers[] = [
                    'store_id' => $storeId,
                    'name' => 'cashier'.$storeId.'_'.$i,
                    'email' => 'cashier'.$storeId.'_'.$i.'@gmail.com',
                    'password' => Hash::make('12345678'),
                    'phone' => '09'.rand(10000000, 99999999),
                    'role' => 'cashier',
                    'expired' => rand(1, 3),
                    'biography' => fake()->paragraph(2),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Thêm vào db
        User::query()->insert($listUsers);
    }
}
