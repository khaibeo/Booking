<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\InvoiceService;
use App\Services\StoreService;

class HomeController extends Controller
{
    protected $invoiceService;

    protected $storeService;

    public function __construct(InvoiceService $invoiceService, StoreService $storeService)
    {
        $this->invoiceService = $invoiceService;
        $this->storeService = $storeService;
    }

    public function index()
    {
        $storeId = Auth()->user()->store_id;

        $store = $this->storeService->getStoreById($storeId);

        // Tính tổng số lượng booking
        $bookingCount = $this->invoiceService->getBookingCount($storeId);

        // Tính tổng số lượng hóa đơn
        $invoiceCount = $this->invoiceService->getInvoiceCount($storeId);

        // Tính tổng số lượng dịch vụ
        $serviceCount = $this->invoiceService->getServiceCount($storeId);

        // Tính tổng doanh thu
        $totalRevenue = $this->invoiceService->getTotalRevenue($storeId);

        // Hóa đơn gần đây
        $latestInvoices = $this->invoiceService->getLatestInvoices($storeId);

        // Doanh thu theo từng loại dịch vụ và chuẩn bị dữ liệu cho biểu đồ
        $revenueByService = $this->invoiceService->getRevenueByService($storeId);
        $serviceNames = $revenueByService->pluck('name');
        $revenues = $revenueByService->pluck('revenue');

        // Doanh thu 12 tháng gần nhất và chuẩn bị dữ liệu cho biểu đồ
        $monthlyData = $this->invoiceService->getMonthlyRevenueAndAverage($storeId);

        $monthlyLabels = [];
        $monthlyRevenues = [];
        $averagePerInvoice = [];

        foreach ($monthlyData as $data) {
            $monthlyLabels[] = $data->month.'/'.$data->year; // Nhãn tháng/năm
            $monthlyRevenues[] = $data->total_revenue; // Tổng doanh thu
            $averagePerInvoice[] = $data->avg_revenue_per_invoice; // Doanh thu trung bình trên mỗi hóa đơn
        }

        $data = [
            'store' => $store,
            'invoiceCount' => $invoiceCount,
            'serviceCount' => $serviceCount,
            'bookingCount' => $bookingCount,
            'totalRevenue' => $totalRevenue,
            'latestInvoices' => $latestInvoices,
            'serviceNames' => $serviceNames,
            'revenues' => $revenues,
            'monthlyLabels' => $monthlyLabels,       // Nhãn tháng/năm cho biểu đồ cột
            'monthlyRevenues' => $monthlyRevenues,   // Doanh thu theo tháng cho biểu đồ cột
            'averagePerInvoice' => $averagePerInvoice,   // Doanh thu theo tháng cho biểu đồ cột
        ];

        return view('admin.dashboard', $data);
    }
}
