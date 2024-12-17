<?php

namespace App\Services;

use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public function create(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $imageId = $data['image_id'];
        unset($data['image_id']);

        if (! isset($data['store_id'])) {
            $data['store_id'] = auth()->user()->store_id;
        }

        $user = User::create($data);

        $image = Image::query()->find($imageId);
        $image->imageable_type = 'App\Models\User';
        $image->imageable_id = $user->id;
        $image->save();

        return $user;
    }

    public function update(User $user, array $data)
    {
        $oldImageId = $user->image?->id;
        $oldImage = $user->image?->path;

        if ($data['image_id']) {
            if ($oldImageId && $data['image_id'] != $oldImageId) {
                if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                    $user->image()->delete();
                }

                $image = Image::query()->find($data['image_id']);
                $image->imageable_type = 'App\Models\User';
                $image->imageable_id = $user->id;
                $image->save();
            }

            unset($data['image_id']);
        }

        return $user->update($data);
    }

    public function getListUser(Request $request, $storeId = '')
    {
        $query = User::query()->with(['store', 'image'])
            ->select('id', 'store_id', 'name', 'role', 'phone', 'created_at');

        if ($storeId) {
            $query = $query->where('store_id', $storeId);
        }

        // Lọc theo tên
        if ($request->filled('name')) {
            $query->where('name', 'like', '%'.$request->input('name').'%');
        }

        // Lọc theo vai trò
        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }

        $users = $query->orderBy('id', 'desc')->paginate(10)->appends($request->except('page'));

        return $users;
    }

    public function delete(User $user)
    {
        $imagePath = $user->image?->path;
        if (Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }

        $user->schedules()->delete();
        // $user->image()->delete();

        return $user->delete();
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
