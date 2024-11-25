<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Service;
use App\Models\Store;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class BookingSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Nhóm nhân viên theo cửa hàng
        $staffByStore = User::where('role', 'staff')
            ->get()
            ->groupBy('store_id');

        $stores = Store::all();
        $services = Service::all();

        foreach (range(1, 50) as $index) {
            $store = $stores->random();

            // Chọn một nhân viên ngẫu nhiên từ cửa hàng đã chọn
            $staff = $this->getRandomStaffFromStore($staffByStore, $store->id);

            // Nếu không có nhân viên nào trong cửa hàng này, chọn cửa hàng khác
            if (! $staff) {
                continue;
            }

            // Tạo ngày booking trong khoảng 3 ngày trước đến 3 ngày sau
            $bookingDate = Carbon::now()->subDays(3)->addDays($faker->numberBetween(0, 6))->format('Y-m-d');
            $bookingTime = $faker->time('H:i:00');
            $endTime = Carbon::parse($bookingTime)->addHours(2)->format('H:i:00');

            $booking = Booking::create([
                'user_id' => $staff->id,
                'store_id' => $store->id,
                'name' => $faker->name,
                'phone' => $faker->phoneNumber,
                'booking_date' => $bookingDate,
                'booking_time' => $bookingTime,
                'end_time' => $endTime,
                'note' => $faker->sentence,
                'total_amount' => 0, // Sẽ được cập nhật sau
                'status' => $faker->randomElement(['pending', 'confirmed', 'completed', 'cancelled']),
                'created_at' => Carbon::parse($bookingDate)->setTimeFromTimeString($bookingTime),
                'updated_at' => Carbon::parse($bookingDate)->setTimeFromTimeString($bookingTime),
            ]);

            // Tạo booking details
            $numberOfServices = $faker->numberBetween(1, 3);
            $totalAmount = 0;

            for ($i = 0; $i < $numberOfServices; $i++) {
                $service = $services->random();
                $price = $service->price;

                BookingDetail::create([
                    'booking_id' => $booking->id,
                    'service_id' => $service->id,
                    'price' => $price,
                ]);

                $totalAmount += $price;
            }

            // Cập nhật tổng số tiền cho booking
            $booking->update(['total_amount' => $totalAmount]);
        }
    }

    private function getRandomStaffFromStore(Collection $staffByStore, $storeId)
    {
        if (! $staffByStore->has($storeId) || $staffByStore[$storeId]->isEmpty()) {
            return null;
        }

        return $staffByStore[$storeId]->random();
    }
}
