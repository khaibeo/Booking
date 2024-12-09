<?php

namespace App\Services;

use App\Models\Image;
use App\Models\StaffSchedule;
use App\Models\Store;
use App\Models\User;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserService
{
    use ImageUploadTrait;

    public function createUser(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        if (isset($data['image'])) {
            $path = $this->uploadFile($data['image'], 'image_users');

            $image = Image::create(['path' => $path]);

            $data['image_id'] = $image->id;
        }

        return User::create($data);
    }

    public function create(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        if (isset($data['image_id'])) {
            $data['image_id'] = $data['image_id'];
        }

        if (!isset($data['store_id'])) {
            $data['store_id'] = auth()->user()->store_id;
        }

        return User::create($data);
    }

    public function getStores()
    {
        return Store::all();
    }

    public function updateUser(User $user, array $data)
    {
        if (isset($data['image'])) {
            $image = $this->handleImage(
                $data['image'],
                $user->image?->path,
                'user_images'
            );

            $user->image()->delete();

            $user->image()->create($image);
        }

        return $user->update($data);
    }

    public function update($id, array $data)
    {
        $user = $this->getUserById($id);

        $oldImageId = $user->image_id;
        $oldImage = $user?->image?->path;

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

        return $user->update($data);
    }

    public function getListUser(Request $request, $storeId = '')
    {
        $query = User::query()->with(['store', 'image'])
            ->select('id', 'store_id', 'name', 'image_id', 'role', 'phone', 'created_at');

        if ($storeId) {
            $query = $query->where('store_id', $storeId);
        }

        // Lọc theo tên
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        // Lọc theo vai trò
        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }

        $users = $query->orderBy('id', 'desc')->paginate(10)->appends($request->except('page'));

        return $users;
    }

    public function deleteUser(User $user)
    {
        StaffSchedule::query()->where('user_id', $user->id)->delete();

        // Xóa nhân viên
        return $user->delete();
    }

    public function getUserById($id)
    {
        return User::with(['store', 'image'])->find($id);
    }

    public function checkPassword(User $user, $password)
    {
        return Hash::check($password, $user->password);
    }

    public function changePassword(User $user, $newPassword)
    {
        return $user->update(['password' => Hash::make($newPassword)]);
    }
}
