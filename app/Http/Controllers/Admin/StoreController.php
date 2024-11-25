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

    /**
     * Hiển thị danh sách các cửa hàng.
     */
    public function index()
    {
        $stores = Store::query()->orderBy('created_at', 'desc')->paginate(10);

        return view(self::PATH_VIEW.__FUNCTION__, compact('stores'));
    }

    /**
     * Hiển thị form để tạo một store mới.
     */
    public function create()
    {
        return view(self::PATH_VIEW.__FUNCTION__);
    }

    /**
     * Thêm một store mới vào cơ sở dữ liệu.
     */
    public function store(StoreStoreRequest $request)
    {
        // Gọi phương thức createStore từ StoreService để xử lý lưu trữ store mới.
        $this->storeService->createStore($request->except('image'), $request->file('image'));

        return redirect()->route('admin.stores.index')->with('success', 'Thêm mới thành công');
    }

    /**
     * Hiển thị form để chỉnh sửa một store cụ thể.
     */
    public function edit(Store $store)
    {
        $imagePath = $store->image?->path;
        $imageId = $store->image?->id;

        return view(self::PATH_VIEW.__FUNCTION__, compact('store', 'imagePath', 'imageId'));
    }

    /**
     * Cập nhật thông tin của một store.
     */
    public function update(UpdateStoreRequest $request, Store $store)
    {
        // Gọi phương thức updateStore từ StoreService để xử lý cập nhật thông tin store.
        $this->storeService->update($store, $request->validated());

        return back()->with('success', 'Cập nhật thành công');
    }

    /**
     * Xóa một store cụ thể khỏi cơ sở dữ liệu.
     */
    public function destroy(Store $store)
    {
        // Kiểm tra xem cửa hàng có nhân viên hay không
        if ($store->users()->count() > 0) {
            // Hiển thị thông báo xác nhận
            return back()->with('error', 'Cửa hàng có nhân viên. Bạn không thể xóa');
        }

        // Nếu không có nhân viên, xóa cửa hàng ngay lập tức
        $this->storeService->deleteStore($store);

        return back()->with('success', 'Xóa thành công');
    }

    public function editInforStore(int $id)
    {
        $store = $this->storeService->loadIdStore($id);

        // Nếu không tìm thấy cửa hàng, trả về lỗi
        if (! $store) {
            return redirect()->route('admin.stores.index')->with('error', 'Không tìm thấy thông tin chi tiết cửa hàng');
        }

        $this->authorize('edit', $store);

        $this->view['idStore'] = $store;

        return view('admin.stores.edit-information', $this->view);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateInfor(UpdateStoreRequest $request, int $id)
    {
        $store = $this->storeService->loadIdStore($id);

        // Nếu không tìm thấy cửa hàng, trả về lỗi
        if (! $store) {
            return redirect()->back()->withErrors(['error' => 'Cửa hàng không tồn tại.']);
        }

        $this->authorize('update', $store);

        // Lấy dữ liệu từ request
        $data = $request->validated();

        // Nếu không có ảnh mới và không có ảnh cũ thì trả về lỗi
        if (! $request->has('image') && ! $store->image) {
            return redirect()->back()->withErrors(['error' => 'Trong kho lưu trữ không có ảnh cửa hàng, yêu cầu cung cấp ảnh cửa hàng']);
        }

        $data['image'] = $this->handleImage(
            $request->file('image'),
            $store->image,
            'image_stores'
        );

        // Sử dụng phương thức updateStore để cập nhật dữ liệu
        $this->storeService->updateStore($data, $id); // Cập nhật cửa hàng

        // Chuyển hướng về view edit và truyền dữ liệu cửa hàng
        return redirect()->route('admin.stores.edit_infor', ['id' => $store->id])->with('success', 'Cập nhật thành công!');
    }

    // Hiển thị nhân viên theo cửa hàng
    public function showStoreStaffs(Request $request, Store $store)
    {
        $staffs = $this->storeService->getStoreStaff($request, $store);

        return view(self::PATH_VIEW.'staff', compact('staffs'));
    }
}
