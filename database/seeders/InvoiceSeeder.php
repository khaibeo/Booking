<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Store;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class InvoiceSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $stores = Store::all();
        $services = Service::all();

        // Xác định khoảng thời gian 6 tháng gần đây
        $endDate = Carbon::now();
        $startDate = $endDate->copy()->subMonths(6);

        foreach ($stores as $store) {
            // Lấy danh sách nhân viên thu ngân (cashier) thuộc cửa hàng này
            $cashiers = User::where('store_id', $store->id)
                ->where('role', 'cashier')
                ->pluck('id')
                ->toArray();

            // Bỏ qua nếu cửa hàng không có nhân viên thu ngân
            if (empty($cashiers)) {
                continue;
            }

            // Tạo từ 10 đến 30 hóa đơn cho mỗi cửa hàng
            for ($i = 0; $i < $faker->numberBetween(10, 30); $i++) {
                // Tạo ngày ngẫu nhiên trong khoảng 6 tháng gần đây
                $randomDate = Carbon::instance($faker->dateTimeBetween($startDate, $endDate));

                // Tạo hóa đơn
                $invoiceId = DB::table('invoices')->insertGetId([
                    'code' => strtoupper(substr(bin2hex(random_bytes(3)), 0, 8)),
                    'store_id' => $store->id,
                    'user_id' => $faker->randomElement($cashiers),
                    'name' => $faker->name,
                    'phone' => $this->generateVietnamesePhoneNumber(),
                    'total_amount' => 0, // Sẽ được cập nhật sau khi tạo chi tiết hóa đơn
                    'payment_method' => $faker->randomElement(['cash', 'transfer']),
                    'created_at' => $randomDate,
                    'updated_at' => $randomDate,
                ]);

                // Tạo chi tiết hóa đơn
                $totalAmount = 0;
                $numberOfServices = $faker->numberBetween(1, 5);
                $usedServices = $faker->randomElements($services, $numberOfServices);

                foreach ($usedServices as $service) {
                    $price = $service->price;
                    $totalAmount += $price;

                    DB::table('invoice_details')->insert([
                        'invoice_id' => $invoiceId,
                        'service_id' => $service->id,
                        'price' => $price,
                        'created_at' => $randomDate,
                        'updated_at' => $randomDate,
                    ]);
                }

                // Cập nhật tổng tiền cho hóa đơn
                DB::table('invoices')->where('id', $invoiceId)->update([
                    'total_amount' => $totalAmount,
                ]);
            }
        }
    }

    private function generateVietnamesePhoneNumber()
    {
        $prefixes = ['09', '08', '07', '03']; // Các mã vùng phổ biến ở Việt Nam
        $prefix = $prefixes[array_rand($prefixes)]; // Chọn một mã vùng ngẫu nhiên
        $number = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT); // Tạo số điện thoại 8 chữ số

        return $prefix.$number; // Kết hợp mã vùng và số điện thoại

    }
}
