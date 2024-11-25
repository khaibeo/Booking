<?php

namespace App\Services\Api\Bookings;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingService
{
    const VALID_STATUSES = ['pending', 'confirmed', 'completed', 'cancelled'];

    public function getAllBookings($filters = [])
    {
        $listBookings = Booking::with('user', 'store');

        if (! empty($filters['customer_name'])) {
            $listBookings->where('name', 'like', '%'.$filters['customer_name'].'%');
        }

        if (! empty($filters['store_id'])) {
            $listBookings->where('store_id', $filters['store_id']);
        }

        if (! empty($filters['status'])) {
            $listBookings->where('status', $filters['status']);
        }

        return $listBookings->orderBy('created_at', 'desc')->paginate(10);
    }

    public function updateBookingStatus(Request $request, Booking $booking)
    {
        $status = $request->input('status');

        if (! in_array($status, self::VALID_STATUSES)) {
            return response()->json(['error' => 'Trạng thái không hợp lệ.'], 400);
        }

        if ($booking->status === 'completed' && $status === 'cancelled') {
            return response()->json(['error' => 'Không thể hủy đơn hàng đã hoàn thành.'], 400);
        }

        $currentStatusIndex = array_search($booking->status, self::VALID_STATUSES);
        $newStatusIndex = array_search($status, self::VALID_STATUSES);

        if ($newStatusIndex < $currentStatusIndex) {
            return response()->json(['error' => 'Không thể quay lại trạng thái trước.'], 400);
        }

        $booking->update(['status' => $status]);

        return $status;
    }
}
