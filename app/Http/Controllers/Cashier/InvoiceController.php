<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInvoiceRequest;
use App\Models\Invoice;
use App\Services\BookingService;
use App\Services\InvoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    protected $invoiceService;

    protected $bookingService;

    public function __construct(InvoiceService $invoiceService, BookingService $bookingService)
    {
        $this->invoiceService = $invoiceService;
        $this->bookingService = $bookingService;
    }

    public function index(Request $request)
    {
        $storeId = auth()->user()->store_id;
        $invoices = $this->invoiceService->getInvoices($request, $storeId);

        return view('cashier.invoices.index', compact('invoices'));
    }

    public function show(Invoice $invoice)
    {
        $this->checkStore($invoice);

        $invoiceDetails = $invoice->details()->get();

        return view('cashier.invoices.detail', compact('invoice', 'invoiceDetails'));
    }

    public function create(Request $request)
    {
        $services = $this->invoiceService->getServices();
        $booking = null;

        if ($request->has('booking_id')) {
            $booking = $this->bookingService->getBookingDetail($request->booking_id);

            if ($booking->store_id != Auth()->user()->store_id) {
                abort(403);
            }

            if ($booking->status != 'completed') {
                return back()->with('error', 'Chỉ có thể tạo hóa đơn khi trạng thái là hoàn thành');
            }
        }

        return view('cashier.invoices.create', compact('services', 'booking'));
    }

    public function store(StoreInvoiceRequest $request)
    {
        try {
            DB::beginTransaction();

            $invoice = $this->invoiceService->storeInvoice($request);

            DB::commit();

            return redirect()->route('cashier.invoices.detail', $invoice);
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Đã xảy ra lỗi khi tạo hóa đơn. Vui lòng thử lại.');
        }
    }

    public function destroy(Invoice $invoice)
    {
        $this->checkStore($invoice);

        try {
            $this->invoiceService->deleteInvoice($invoice);

            return redirect()->route('cashier.invoices.index')
                ->with('success', 'Xóa thành công.');
        } catch (\Exception $e) {
            return back()->with('error', 'Đã xảy ra lỗi khi xóa. Vui lòng thử lại.');
        }
    }

    private function checkStore($invoice)
    {
        if ($invoice->store_id != Auth()->user()->store_id) {
            abort(403);
        }
    }
}
