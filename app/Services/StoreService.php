<?php

namespace App\Services;

use App\Models\Image;
use App\Models\Store;
use App\Models\StoreSchedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoreService
{
    public function getAllStore()
    {
        return Store::query()->orderBy('created_at', 'desc')->paginate(10);
    }

    public function getStoreById($id)
    {
        return Store::query()->find($id);
    }

    public function create(array $data)
    {
        $store = Store::query()->create($data);

        if ($data['image_id']) {
            $image = Image::query()->find($data['image_id']);
            $image->imageable_type = 'App\Models\Store';
            $image->imageable_id = $store->id;
            $image->save();
        }

        return $store;
    }

    public function update($store, array $data)
    {
        $oldImageId = $store->image?->id;
        $oldImage = $store->image?->path;

        if ($data['image_id']) {
            if ($oldImageId && $data['image_id'] == $oldImageId) {
                unset($data['image_id']);
            } else {
                if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                    $store->image()->delete();
                }

                $image = Image::query()->find($data['image_id']);
                $image->imageable_type = 'App\Models\Store';
                $image->imageable_id = $store->id;
                $image->save();

                unset($data['image_id']);
            }
        }

        return $store->update($data);
    }

    public function deleteStore(Store $store)
    {
        $imagePath = $store->image?->path;
        if (Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }

        $store->image()->delete();
        $store->delete();
    }

    public function getStoreStaff(Request $request, $store)
    {
        $query = User::query()
            ->with(['image'])->where('store_id', $store->id)
            ->select('id', 'store_id', 'name', 'role', 'phone', 'email', 'created_at')
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
