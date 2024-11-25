<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\Api\Bookings\BookingService;
use Illuminate\Http\Request;

class BookingApiController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function index()
    {
        $listBookings = $this->bookingService->getAllBookings();

        return $this->responseSuccess('success', $listBookings);
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $updateBooking = $this->bookingService->updateBookingStatus($request, $booking);

        return $this->responseSuccess('success', $updateBooking);
    }

    public function cancelBooking(Booking $booking)
    {

        if ($booking->status == 'completed') {
            return $this->responseBadRequest('Không thể hủy đơn hàng đã hoàn thành');
        }
        $booking->update(['status' => 'cancelled']);

        return $this->responseSuccess('success', 'Hủy chỗ thành công');
    }
}
