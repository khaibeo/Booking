<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingService
{
    const VALID_STATUSES = ['pending', 'confirmed', 'completed', 'cancelled'];

    public function getAllBookings($filters = [])
    {
        $query = Booking::with('user', 'store');

        if (auth()->user()->role == 'manager') {
            $query = $query->whereStoreId(auth()->user()->store_id);
        }

        if (! empty($filters['customer_name'])) {
            $query->where('name', 'like', '%' . $filters['customer_name'] . '%');
        }

        if (! empty($filters['store_id'])) {
            $query->where('store_id', $filters['store_id']);
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('booking_date', 'desc')->paginate(10)->appends(['customer_name' => request('customer_name'), 'store_id' => request('store_id'), 'status' => request('status')]);
    }

    public function getBookingByStore($filters, $store)
    {
        $query = Booking::query()->where('store_id', $store);

        if (! empty($filters['customer_name'])) {
            $query->where('name', 'like', '%' . $filters['customer_name'] . '%');
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('created_at', 'desc')->paginate(10);
    }

    public function updateBookingStatus(Request $request, Booking $booking)
    {
        $status = $request->input('status');

        if (! in_array($status, self::VALID_STATUSES)) {
            return ['error' => 'Trạng thái không hợp lệ.'];
        }

        if ($booking->status === 'completed' && $status === 'cancelled') {
            return ['error' => 'Không thể hủy đơn hàng đã hoàn thành.'];
        }

        $currentStatusIndex = array_search($booking->status, self::VALID_STATUSES);
        $newStatusIndex = array_search($status, self::VALID_STATUSES);

        if ($newStatusIndex < $currentStatusIndex) {
            return ['error' => 'Không thể quay lại trạng thái trước.'];
        }

        $booking->status = $status;
        $booking->save();

        return ['success' => 'Trạng thái đã được cập nhật thành công.'];
    }

    public function cancelBooking(Booking $booking)
    {
        if ($booking->status == 'completed') {
            return ['error' => 'Không thể hủy đặt chỗ đã hoàn thành.'];
        }

        return $booking->delete();
    }

    public function getBookingsForCurrentStaff()
    {
        $staffId = auth()->user()->id;

        $bookings = Booking::where('user_id', $staffId)
            ->with('user', 'store')
            ->latest('booking_date')->latest('booking_time')
            ->paginate(10);

        return $bookings;
    }

    public function getBookingDetail($id)
    {
        return Booking::with(['details.service' => function ($query) {
            $query->withTrashed();
        }])->findOrFail($id);
    }

    public function getStaffBookingToday($date, $staffId = '')
    {
        return Booking::whereDate('booking_date', $date)
            ->latest('booking_time')
            ->where('user_id', $staffId)->paginate(10);
    }
}
