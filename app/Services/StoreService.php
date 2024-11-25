<?php

namespace App\Services;

use App\Models\Image;
use App\Models\Store;
use App\Models\StoreSchedule;
use App\Models\User;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoreService
{
    use ImageUploadTrait;

    /**
     * Tạo một cửa hàng mới.
     */
    public function createStore(array $data, $file = null)
    {
        if ($file) {
            // Sử dụng phương thức handleImage từ Trait để xử lý upload ảnh
            $path = $this->uploadFile($file, 'image_stores');

            $image = Image::create(['path' => $path]);

            $data['image_id'] = $image->id;
        }

        return Store::query()->create($data);
    }

    /**
     * Cập nhật thông tin của một cửa hàng.
     */
    public function updateStores(Store $store, array $data, $file = null)
    {
        // Nếu có ảnh mới
        if ($file) {
            // Sử dụng phương thức handleImage từ Trait để xử lý upload và xóa ảnh cũ
            $data['image'] = $this->handleImage($file, $store->image, 'image_stores');
        }

        // Cập nhật thông tin của cửa hàng
        $store->update($data);
    }

    public function update($store, array $data)
    {
        $oldImageId = $store->image_id;
        $oldImage = $store?->image?->path;

        if ($data['image_id']) {
            if ($oldImageId && $data['image_id'] == $oldImageId) {
                unset($data['image_id']);
            } else {
                if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }

                $data['image_id'] = $data['image_id'];
            }
        } else {
            if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }
        }

        return $store->update($data);
    }

    public function loadIdStore($id)
    {
        return Store::query()->find($id);
    }

    public function updateStore($params, $id)
    {
        $store = Store::query()->find($id);
        if (! $store) {
            return ['error' => 'Store not found'];
        }
        $store->update($params);

        return $store;
    }

    /**
     * Xóa một cửa hàng khỏi hệ thống.
     */
    public function deleteStore(Store $store)
    {
        // Xóa ảnh khi xóa cửa hàng
        $imagePath = $store->image;
        if (Storage::exists($imagePath)) {
            Storage::delete($imagePath);
        }

        // Xóa cửa hàng
        $store->delete();
    }

    // Lấy nhân viên theo cửa hàng
    public function getStoreStaff(Request $request, $store)
    {
        $query = User::query()
            ->with(['image'])->where('store_id', $store->id)
            ->select('id', 'store_id', 'name', 'image_id', 'role', 'phone', 'email', 'created_at')
            ->orderBy('created_at', 'desc');

        // Lọc theo tên
        if ($request->filled('name')) {
            $query->where('name', 'like', '%'.$request->input('name').'%');
        }

        // Phân trang
        $users = $query->paginate(10)->appends($request->except('page'));

        return $users;
    }

    public function getStoreSchedules()
    {
        $storeId = auth()->user()->store_id;

        return StoreSchedule::where('store_id', $storeId)
            ->where('date', '>=', now()->format('Y-m-d'))
            ->orderBy('date', 'desc')
            ->get();
    }

    public function checkStoreSchedule($user, $date)
    {
        $storeId = $user->store_id;

        return StoreSchedule::where('store_id', $storeId)
            ->where('date', $date)
            ->first();
    }
}
