<?php

namespace App\Services;

use App\Http\Requests\Admin\OpeningStoreRequest;
use App\Models\Store;
use App\Models\StoreSchedule;
use Illuminate\Support\Carbon;

class OpeningService
{
    protected $storeModel;

    protected $storeScheduleModel;

    public function __construct(Store $storeModel, StoreSchedule $storeScheduleModel)
    {
        $this->storeModel = $storeModel;
        $this->storeScheduleModel = $storeScheduleModel;
    }

    public function getAllOpening()
    {
        return StoreSchedule::with('store')->get();
    }

    public function getOpeningStore($storeId)
    {
        $store = $this->storeScheduleModel->where('store_id', $storeId)->orderBy('date', 'desc')->get();

        return $store ?? [];
    }

    public function createOpening(int $storeId, array $request)
    {
        $startDate = Carbon::parse($request['date']);
        $endDate = Carbon::parse($request['end_date']);
        $openTime = Carbon::parse($request['opening_time']);
        $closeTime = Carbon::parse($request['closing_time']);

        $workingDays = [];

        while ($startDate <= $endDate) {
            $workingDays[] = [
                'date' => $startDate->format('Y-m-d'),
                'opening_time' => $openTime->format('H:i:s'),
                'closing_time' => $closeTime->format('H:i:s'),
            ];
            $startDate->addDay();
        }

        foreach ($workingDays as $day) {
            StoreSchedule::create(array_merge(['store_id' => $storeId], $day));
        }

        return true;
    }

    public function findStoreId($storeId)
    {
        return Store::find($storeId);
    }

    public function updateOpening($id, $storeId, OpeningStoreRequest $request)
    {
        return StoreSchedule::where(['store_id' => $storeId, 'id' => $id])->update($request->validated());
    }

    public function deleteOpening($storeId, $id)
    {
        return StoreSchedule::where(['store_id' => $storeId, 'id' => $id])->delete();
    }

    public function exitsDay($storeId, $date)
    {
        return StoreSchedule::where('store_id', $storeId)->where('date', $date)->exists();
    }
}
