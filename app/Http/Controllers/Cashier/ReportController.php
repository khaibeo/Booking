<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Services\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function index(Request $request)
    {
        $storeId = auth()->user()->store_id;
        //Top dịch vụ sử dụng nhiều
        $topServices = $this->reportService->getTopServices($storeId);

        //Tổng hóa đơn
        $invoiceCount = $this->reportService->getInvoiceCount($storeId);

        //Dịch vụ đã sử dụng
        $serviceCount = $this->reportService->getServiceCount($storeId);

        //Dịch vụ đã sử dụng
        $totalRevenue = $this->reportService->getTotalRevenue($storeId);

        $data = [
            'topServices' => $topServices,
            'invoiceCount' => $invoiceCount,
            'serviceCount' => $serviceCount,
            'totalRevenue' => $totalRevenue,
        ];

        return view('cashier.report.index', $data);
    }
}
