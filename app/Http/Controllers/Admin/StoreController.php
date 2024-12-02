<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\UpdateStoreRequest;
use App\Models\Store;
// use App\Http\Requests\Admin\UpdateStoreRequest;
use App\Services\StoreService;
// use App\Services\StoreService;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    use ImageUploadTrait;

    const PATH_VIEW = 'admin.stores.';

    protected $storeService;

    private $view;

    public function __construct(StoreService $storeService)
    {
        $this->view = [];

        $this->storeService = $storeService;
    }

    public function index()
    {
        $this->authorize('viewAllStore', Store::class);

        $stores = Store::query()->orderBy('created_at', 'desc')->paginate(10);

        return view(self::PATH_VIEW.__FUNCTION__, compact('stores'));
    }

    public function create()
    {
        $this->authorize('create', Store::class);

        return view(self::PATH_VIEW.__FUNCTION__);
    }

    public function store(StoreStoreRequest $request)
    {
        $this->authorize('store', Store::class);

        $this->storeService->createStore($request->except('image'), $request->file('image'));

        return redirect()->route('admin.stores.index')->with('success', 'Thêm mới thành công');
    }

    public function edit(Store $store)
    {
        $this->authorize('edit', $store);

        $imagePath = $store->image?->path;
        $imageId = $store->image?->id;

        return view(self::PATH_VIEW.__FUNCTION__, compact('store', 'imagePath', 'imageId'));
    }

    public function update(UpdateStoreRequest $request, Store $store)
    {
        $this->authorize('update', $store);

        $this->storeService->update($store, $request->validated());

        return back()->with('success', 'Cập nhật thành công');
    }

    public function destroy(Store $store)
    {
        $this->authorize('delete', $store);

        if ($store->users()->count() > 0) {
            return back()->with('error', 'Cửa hàng có nhân viên. Bạn không thể xóa');
        }

        $this->storeService->deleteStore($store);

        return back()->with('success', 'Xóa thành công');
    }

    public function showStoreStaffs(Request $request, Store $store)
    {
        $this->authorize('viewStaff', $store);

        $staffs = $this->storeService->getStoreStaff($request, $store);

        return view(self::PATH_VIEW.'staff', compact('staffs'));
    }
}
