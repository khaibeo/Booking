<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use App\Models\StaffSchedule;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    public function index(Store $store)
    {
        $startDate = today();
        $endDate = today()->addDays(3);

        // Kiểm tra xem cửa hàng có lịch hoạt động trong 3 ngày tới không
        $hasSchedule = $store->storeSchedule()
            ->whereBetween('date', [$startDate, $endDate])
            ->exists();

        // Nếu không có lịch hoạt động, chuyển hướng về trang chọn cửa hàng với thông báo
        if (! $hasSchedule) {
            abort(404);
        }

        $services = Service::all();

        return view('client.booking.booking', compact('store', 'services'));
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'services' => 'required|array',
                'services.*' => 'exists:services,id',
                'staff_id' => 'required|exists:users,id',
                'store_id' => 'required|exists:stores,id',
                'booking_date' => 'required',
                'booking_time' => 'required',
                'customer_name' => 'required|string|max:255',
                'customer_phone' => 'required|string|max:20',
                'note' => 'nullable',
            ]);

            $validated['booking_time'] = Carbon::parse($validated['booking_time'])
                ->setTimezone('Asia/Ho_Chi_Minh')
                ->format('H:i:s');

            $staff = User::findOrFail($validated['staff_id']);
            $services = Service::whereIn('id', $validated['services'])->get();
            $bookingTime = $validated['booking_time'];
            $bookingDate = Carbon::parse($validated['booking_date'])->format('Y-m-d');

            // Tính tổng thời gian và số tiền
            $totalDuration = $services->sum('duration');
            $totalAmount = $services->sum('price');

            // Tính thời gian kết thúc
            $endTime = Carbon::parse($validated['booking_time'])
                ->addMinutes($totalDuration)
                ->format('H:i:s');

            // Kiểm tra slot có phù hợp hay không
            $existingBookings = Booking::with(['services'])
                ->where('user_id', $staff->id)
                ->where('booking_date', $bookingDate)
                ->where('status', '!=', 'cancelled')
                ->get();

            // Kiểm tra trùng lịch với buffer 10 phút
            foreach ($existingBookings as $existingBooking) {
                if ($this->isTimeSlotOverlapping(
                    Carbon::parse($bookingTime),
                    Carbon::parse($endTime),
                    $existingBooking
                )) {
                    return response()->json([
                        'message' => 'Đã có người đặt lịch trong thời gian này',
                    ], 422);
                }
            }

            $booking = DB::transaction(function () use ($validated, $services, $totalAmount, $bookingTime, $bookingDate, $endTime) {
                $booking = Booking::create([
                    'user_id' => $validated['staff_id'],
                    'store_id' => $validated['store_id'],
                    'name' => $validated['customer_name'],
                    'phone' => $validated['customer_phone'],
                    'booking_date' => $bookingDate,
                    'booking_time' => $bookingTime,
                    'total_amount' => $totalAmount,
                    'end_time' => $endTime,
                    'note' => $validated['note'],
                    'status' => 'pending',
                ]);

                foreach ($services as $service) {
                    $booking->services()->attach($service->id, ['price' => $service->price]);
                }

                return $booking;
            });

            return response()->json([
                'message' => 'Đặt lịch thành công',
                'booking' => $booking->load('services', 'user'),
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Có lỗi xảy ra',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getStaffs(Request $request): JsonResponse
    {
        $storeId = $request->store;
        $startDate = today();
        $endDate = today()->addDays(3);

        $staffs = User::query()
            ->where('role', 'staff')
            ->where('store_id', $storeId)
            ->whereHas('schedules', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('date', [$startDate, $endDate]);
            })
            ->get()
            ->map(function ($staff) {
                return [
                    'id' => $staff->id,
                    'name' => $staff->name,
                    'avatar' => $staff->image?->path,
                ];
            });

        return response()->json($staffs);
    }

    public function availableTimeSlots(Request $request, User $staff): JsonResponse
    {
        $date = $request->input('date');
        $slots = $staff->getAvailableTimeSlots($date);

        return response()->json($slots);
    }

    public function getStaffScheduleRange($staffId, Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date', Carbon::parse($startDate)->addDays(3)->format('Y-m-d'));

        $schedules = StaffSchedule::where('user_id', $staffId)
            ->whereBetween('date', [$startDate, $endDate])
            ->get(['date', 'start_time', 'end_time'])
            ->groupBy(function ($schedule) {
                return Carbon::parse($schedule->date)->format('Y-m-d');
            })
            ->map(function ($daySchedules) {
                return $daySchedules->map(function ($schedule) {
                    return [
                        'start_time' => Carbon::parse($schedule->start_time)->format('H:i'),
                        'end_time' => Carbon::parse($schedule->end_time)->format('H:i'),
                    ];
                });
            });

        return response()->json([
            'status' => 'success',
            'data' => $schedules,
        ]);
    }

    public function getAppointmentsByStaffAndDate(Request $request, $staffId)
    {
        $date = $request->date;
        $appointments = Booking::where('user_id', $staffId)
            ->whereDate('booking_date', $date)
            ->where('status', '!=', 'cancelled')
            ->get([
                'id',
                'booking_date',
                'booking_time',
                'end_time',
                'status',
            ]);

        return response()->json([
            'data' => $appointments,
        ]);
    }

    public function success(Booking $booking)
    {
        return view('client.booking.success', compact('booking'));
    }

    private function isTimeSlotOverlapping(Carbon $newStartTime, Carbon $newEndTime, $existingBooking)
    {
        $allowedOverlap = 10; // Cho phép chồng chéo tối đa 10 phút

        $existingStartTime = Carbon::parse($existingBooking->booking_time);
        $existingEndTime = Carbon::parse($existingBooking->end_time);

        // Tính toán thời gian chồng chéo
        if ($newStartTime <= $existingEndTime && $newEndTime >= $existingStartTime) {
            // Có chồng chéo, tính độ chồng chéo
            $overlapStart = max($newStartTime, $existingStartTime);
            $overlapEnd = min($newEndTime, $existingEndTime);

            // Tính số phút chồng chéo
            $overlapMinutes = $overlapEnd->diffInMinutes($overlapStart);

            // Nếu thời gian chồng chéo > 10 phút thì không cho phép
            return $overlapMinutes > $allowedOverlap;
        }

        // Không có chồng chéo
        return false;
    }
}
