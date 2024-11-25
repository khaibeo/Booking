<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Store::query();

        if ($request->keyword) {
            $query = $query->where('name', 'LIKE', "%$request->keyword%")
                ->orWhere('address', 'LIKE', "%$request->keyword%");
        }

        // Lấy ngày hiện tại và 3 ngày tiếp theo
        $startDate = now()->startOfDay();
        $endDate = now()->addDays(3)->endOfDay();

        $stores = $query->with(['storeSchedule' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        }])
            ->paginate(10)
            ->appends(['keyword' => $request->keyword]);

        foreach ($stores as $store) {
            $store->is_active = $store->storeSchedule->isNotEmpty();
        }

        return view('client.booking.choose-store', compact('stores'));
    }
}
