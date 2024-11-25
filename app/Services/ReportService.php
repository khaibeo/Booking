<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class ReportService
{
    public function getTopServices($storeId = '')
    {
        // Lấy top 10 dịch vụ sử dụng nhiều nhất
        $topServices = InvoiceDetail::select('service_id', DB::raw('COUNT(*) as total_sold'))
            ->whereHas('invoice', function ($query) use ($storeId) {
                $query->where('store_id', $storeId);
            })
            ->groupBy('service_id')
            ->orderBy('total_sold', 'desc')
            ->take(10)
            ->get();

        // Lấy chi tiết thông tin
        $productDetails = $topServices->map(function ($item) {
            $service = Service::withTrashed()->find($item->service_id);

            return [
                'id' => $service->id,
                'name' => $service->name,
                'total_sold' => $item->total_sold,
            ];
        });

        return $productDetails;
    }

    public function getInvoiceCount($storeId = '')
    {
        return Invoice::query()->where('store_id', $storeId)->count();
    }

    public function getServiceCount($storeId = '')
    {
        return InvoiceDetail::whereHas('invoice', function ($query) use ($storeId) {
            $query->where('store_id', $storeId);
        })
            ->distinct()
            ->count('service_id');
    }

    public function getTotalRevenue($storeId = '')
    {
        return Invoice::query()->where('store_id', $storeId)->sum('total_amount');
    }
}
