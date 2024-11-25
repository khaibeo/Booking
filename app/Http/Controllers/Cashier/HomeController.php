<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Services\InvoiceService;

class HomeController extends Controller
{
    protected $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function index()
    {
        $today = now()->startOfDay();
        $storeId = Auth()->user()->store_id;

        // Tính số lượng booking trong ngày hôm nay
        $bookingCount = $this->invoiceService->getBookingCountByDate($today, $storeId);

        // Tính số lượng hóa đơn trong ngày hôm nay
        $invoiceCount = $this->invoiceService->getInvoiceCountByDate($today, $storeId);

        // Tính số lượng dịch vụ trong ngày hôm nay
        $serviceCount = $this->invoiceService->getServiceCountByDate($today, $storeId);

        // Tính tổng doanh thu trong ngày hôm nay
        $totalRevenue = $this->invoiceService->getTotalRevenueByDate($today, $storeId);

        // Hóa đơn gần đây
        $latestInvoices = $this->invoiceService->getLatestInvoices($storeId);

        $data = [
            'invoiceCount' => $invoiceCount,
            'serviceCount' => $serviceCount,
            'bookingCount' => $bookingCount,
            'totalRevenue' => $totalRevenue,
            'latestInvoices' => $latestInvoices,
        ];

        return view('cashier.dashboard', $data);
    }
}
