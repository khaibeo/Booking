<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\UpdateStoreRequest;
use App\Models\Store;
use App\Services\StoreService;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    protected $storeService;

    public function __construct(StoreService $storeService)
    {
        $this->storeService = $storeService;
    }

    public function index(): JsonResponse
    {
        $stores = Store::query()->orderBy('created_at', 'desc');

        return response()->json($stores);
    }

    public function store(StoreStoreRequest $request): JsonResponse
    {
        $this->authorize('create', Store::class); // Phân quyền tạo cửa hàng

        $store = $this->storeService->createStore($request->except('image'), $request->file('image'));

        return response()->json([
            'message' => 'Thêm mới thành công',
            'store' => $store,
        ], 201);
    }

    public function update(UpdateStoreRequest $request, Store $store): JsonResponse
    {
        $this->authorize('update', $store); // Phân quyền cập nhật cửa hàng

        $updatedStore = $this->storeService->updateStore($store, $request->except('image'), $request->file('image'));

        return response()->json([
            'message' => 'Cập nhật thành công',
            'store' => $updatedStore,
        ]);
    }

    public function destroy(Store $store): JsonResponse
    {
        $this->authorize('delete', $store); // Phân quyền xóa cửa hàng

        if ($store->users()->count() > 0) {
            return response()->json([
                'error' => 'Cửa hàng có nhân viên. Bạn không thể xóa',
            ], 400);
        }

        $this->storeService->deleteStore($store);

        return response()->json([
            'message' => 'Xóa thành công',
        ]);
    }

    public function showStoreStaffs(Store $store): JsonResponse
    {
        $this->authorize('viewStaff', $store); // Phân quyền xem nhân viên của cửa hàng

        $staffs = $this->storeService->getStoreStaff($store);

        return response()->json($staffs);
    }
}
