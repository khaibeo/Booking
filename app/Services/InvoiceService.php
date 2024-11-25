<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class InvoiceService
{
    public function getBookingCountByDate($date, $storeId = '')
    {
        return Booking::whereDate('booking_date', $date)->where('store_id', $storeId)->count('id');
    }

    public function getInvoiceCountByDate($date, $storeId = '')
    {
        return Invoice::whereDate('created_at', $date)->where('store_id', $storeId)->count('id');
    }

    public function getServiceCountByDate($date, $storeId = '')
    {
        return InvoiceDetail::whereDate('created_at', $date)
            ->whereHas('invoice', function ($query) use ($storeId) {
                $query->where('store_id', $storeId);
            })
            ->selectRaw('COUNT(DISTINCT service_id) as service_count')
            ->first()
            ->service_count;
    }

    public function getTotalRevenueByDate($date, $storeId = '')
    {
        return Invoice::whereDate('created_at', $date)->where('store_id', $storeId)->sum('total_amount');
    }

    public function getLatestInvoices($storeId = '')
    {
        $role = Auth()->user()->role; // Lấy vai trò của người dùng đăng nhập

        $query = Invoice::query()
            ->select('id', 'code', 'created_at', 'total_amount', 'payment_method')
            ->where('store_id', $storeId)
            ->orderBy('created_at', 'desc')
            ->take(10);

        // Nếu vai trò là staff, chỉ lấy các hóa đơn trong ngày hiện tại
        if ($role === 'staff') {
            $query->whereDate('created_at', now()->toDateString());
        }

        return $query->get();
    }

    public function getInvoiceCount($storeId = '')
    {
        $role = Auth()->user()->role; // Lấy vai trò của người dùng đăng nhập

        if ($role === 'manager') {
            // Nếu là manager, đếm tất cả hóa đơn của store
            return Invoice::where('store_id', $storeId)->count();
        } elseif ($role === 'staff') {
            // Nếu là staff, đếm hóa đơn theo ngày hiện tại
            return Invoice::where('store_id', $storeId)
                ->whereDate('created_at', now()->toDateString())
                ->count();
        }

        return 0;
    }

    // public function getServiceCount($storeId = '')
    // {
    //     return InvoiceDetail::query()
    //         ->where('store_id', $storeId)
    //         ->groupBy('service_id')
    //         ->count();
    // }
    public function getServiceCount($storeId = '')
    {
        $role = Auth()->user()->role; // Lấy vai trò của người dùng đăng nhập

        // Sử dụng whereHas để lọc các hóa đơn dựa trên vai trò của người dùng
        $query = InvoiceDetail::whereHas('invoice', function ($query) use ($storeId, $role) {
            $query->where('store_id', $storeId);

            // Nếu người dùng là staff, lọc hóa đơn theo ngày hiện tại
            if ($role === 'staff') {
                $query->whereDate('created_at', now()->toDateString());
            }
        });

        // Đếm số lượng service_id độc nhất trong các hóa đơn đã lọc
        return $query->selectRaw('COUNT(DISTINCT service_id) as service_count')
            ->first()
            ->service_count ?? 0;
    }

    public function storeInvoice(Request $request)
    {
        $cashier = Auth::user();
        $store = $cashier->store;

        $invoice = Invoice::create([
            'code' => $store->code.'-'.now()->timestamp,
            'user_id' => $cashier->id,
            'store_id' => $store->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'payment_method' => $request->payment_method,
            'total_amount' => 0,
        ]);

        $totalAmount = 0;

        foreach ($request->services as $serviceData) {
            $service = Service::findOrFail($serviceData['id']);
            $price = $service->price;

            InvoiceDetail::create([
                'invoice_id' => $invoice->id,
                'service_id' => $service->id,
                'price' => $price,
            ]);

            $totalAmount += $price;
        }

        $invoice->update(['total_amount' => $totalAmount]);

        return $invoice;
    }

    public function getServices()
    {
        return Service::select('id', 'name', 'price')->get();
    }

    public function getInvoices(Request $request, $storeId = '')
    {
        $query = Invoice::query()
            ->select('id', 'code', 'created_at', 'total_amount', 'payment_method')
            ->where('store_id', $storeId)
            ->orderBy('created_at', 'desc');

        // Lọc theo ngày bắt đầu và/hoặc ngày kết thúc
        if ($request->filled('start_date') || $request->filled('end_date')) {
            if ($request->filled('start_date')) {
                $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
                $query->where('created_at', '>=', $startDate);
            }

            if ($request->filled('end_date')) {
                $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
                $query->where('created_at', '<=', $endDate);
            }
        }

        // Lọc theo mã hóa đơn
        if ($request->filled('code')) {
            $query->where('code', $request->input('code'));
        }

        // Phân trang
        $invoices = $query->paginate(10)->appends($request->except('page'));

        return $invoices;
    }

    public function deleteInvoice(Invoice $invoice)
    {
        $invoice->details()->delete();
        $invoice->delete();
    }

    public function getBookingCount($storeId = '')
    {
        $role = Auth()->user()->role; // Lấy vai trò của người dùng đăng nhập

        if ($role === 'manager') {
            // Nếu là manager, đếm tổng số lượng booking của store
            return Booking::where('store_id', $storeId)->count('id');
        } elseif ($role === 'staff') {
            // Nếu là staff, đếm số lượng booking theo ngày hiện tại
            return Booking::where('store_id', $storeId)
                ->whereDate('created_at', now()->toDateString())
                ->count('id');
        }

        return 0; // Trả về 0 nếu không phải manager hoặc staff
    }

    public function getTotalRevenue($storeId = '')
    {
        $role = Auth()->user()->role; // Lấy vai trò của người dùng đăng nhập

        $query = Invoice::where('store_id', $storeId);

        // Nếu người dùng là staff, thêm điều kiện lấy hóa đơn theo ngày hiện tại
        if ($role === 'staff') {
            $query->whereDate('created_at', now()->toDateString());
        }

        // Tính tổng doanh thu
        return $query->sum('total_amount');
    }

    public function getRevenueByService($storeId = '')
    {
        return InvoiceDetail::join('services', 'invoice_details.service_id', '=', 'services.id')
            ->join('invoices', 'invoice_details.invoice_id', '=', 'invoices.id')
            ->select('services.name', InvoiceDetail::raw('SUM(invoice_details.price) as revenue'))
            ->where('invoices.store_id', $storeId)
            ->groupBy('services.name')
            ->get();
    }

    public function getMonthlyRevenueAndAverage($storeId = '')
    {
        return Invoice::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(total_amount) as total_revenue, AVG(total_amount) as avg_revenue_per_invoice')
            ->where('created_at', '>=', now()->subMonths(12)) // Lấy dữ liệu trong 12 tháng gần nhất
            ->where('store_id', $storeId)
            ->groupByRaw('YEAR(created_at), MONTH(created_at)')
            ->orderByRaw('YEAR(created_at), MONTH(created_at)')
            ->get();
    }
}
