<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OpeningStoreRequest;
use Illuminate\Http\Request;

class StoreScheduleController extends Controller
{
    public function index($storeId)
    {
        $getOpeningStore = $this->openingService->getOpeningStore($storeId);
        $storeId = $this->openingService->findStoreId($storeId);

        return view('admin.stores.store_schedule', compact(['getOpeningStore', 'storeId']));
    }

    public function create($storeId)
    {
        return view('admin.stores.store_schedule', compact('storeId'));
    }

    public function store($storeId, OpeningStoreRequest $request)
    {
        try {
            if ($this->openingService->exitsDay($storeId, $request->date)) {
                return redirect()->back()->with('error', 'Ngày đã tồn tại . Vui lòng cập nhật lại !');
            } else {
                $this->openingService->createOpening($storeId, $request->validated());

                return redirect()->back()->with('success', 'Thêm mới giờ mở cửa thành công ');
            }
        } catch (\Exception $th) {
            dd($th->getMessage());

            return redirect()->back()->with('error', 'Thêm mới giờ mở cửa thất bại. Vui lòng kiểm tra lại dữ liệu !');

        }
    }

    public function show(string $storeId)
    {
        $storeId = $this->openingService->findStoreId($storeId);

        return view('admin.stores.store_schedule', compact('storeId'));
    }

    public function update($storeId, string $id, OpeningStoreRequest $request)
    {
        $this->openingService->updateOpening($id, $storeId, $request);

        return redirect()->back()->with('success', 'Cập nhật giờ mở cửa thành công');
    }

    public function destroy($storeId, string $id, Request $request)
    {
        try {
            $this->openingService->deleteOpening($storeId, $id);

            return redirect()->back()->with('success', 'Xoá giờ mở cửa thành công');
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
