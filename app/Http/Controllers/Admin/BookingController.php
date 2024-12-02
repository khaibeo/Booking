<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Store;
use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    const PATH_VIEW = 'admin.bookings.';

    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['customer_name', 'store_id', 'status']);

        $bookings = $this->bookingService->getAllBookings($filters);
        $stores = Store::all();

        return view('admin.bookings.index', compact('bookings', 'stores'));
    }

    public function show(Booking $booking)
    {
        $this->authorize('show', $booking);

        $bookingDetail = $booking->details()->with(['service' => function ($query) {
            $query->withTrashed();
        }])->get();

        $booking->load(['user' => function ($query) {
            $query->withTrashed();
        }]);

        return view('admin.bookings.show', compact('booking', 'bookingDetail'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $this->authorize('update', $booking);

        $result = $this->bookingService->updateBookingStatus($request, $booking);
        if (isset($result['error'])) {
            return redirect()->back()->with('error', $result['error']);
        }

        return redirect()->route('admin.bookings.index')->with('success', $result['success']);
    }

    public function cancel(Request $request, Booking $booking)
    {
        $this->authorize('delete', $booking);

        $result = $this->bookingService->cancelBooking($booking);
        if (isset($result['error'])) {
            return redirect()->back()->with('error', $result['error']);
        }

        return redirect()->back()->with('success', $result['success']);
    }

    public function showBookingsForStaff()
    {
        $bookings = $this->bookingService->getBookingsForCurrentStaff();

        return view('admin.bookings.staff', compact('bookings'));
    }
}
