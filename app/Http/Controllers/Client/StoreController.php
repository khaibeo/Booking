<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Support\Carbon;

class StoreController extends Controller
{
    public function show(Store $store)
    {
        $startDate = Carbon::today();
        $endDate = Carbon::today()->addDays(3);

        $storeSchedules = $store->storeSchedule()
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date')
            ->get();

        return view('client.booking.detail-store', compact('store', 'storeSchedules'));
    }
}
