<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\Store;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    const PATH_VIEW = 'admin.users.';

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $storeId = auth()->user()->store_id ?? '';
        $users = $this->userService->getListUser($request, $storeId);

        return view(self::PATH_VIEW.__FUNCTION__, compact('users'));
    }

    public function create()
    {
        $stores = Store::all();

        return view(self::PATH_VIEW.__FUNCTION__, compact('stores'));
    }

    public function store(StoreUserRequest $request)
    {
        $this->userService->create($request->validated());

        return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được tạo thành công.');
    }

    public function edit(User $user)
    {
        $this->authorize('view', $user);

        $stores = $this->userService->getStores();
        $user = $this->userService->getUserById($user->id);
        $imagePath = $user->image?->path;
        $imageId = $user->image?->id;

        return view(self::PATH_VIEW.__FUNCTION__, compact('user', 'stores', 'imagePath', 'imageId'));
    }

    public function update(StoreUserRequest $request, User $user)
    {
        $this->authorize('update', $user);
        try {
            $this->userService->update($user->id, $request->validated());

            return back()->with('success', 'Cập nhật nhân viên thành công');
        } catch (\Throwable $th) {
            return back()->with('error', 'Cập nhật nhân viên không thành công. Vui lòng kiểm tra lại thông tin !');
        }
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        try {
            if ($user->id == auth()->user()->id) {
                return back()->with('error', 'Không thể xóa tài khoản của chính mình');
            }
            $this->userService->deleteUser($user);

            return back()->with('success', 'Xóa thành công');
        } catch (\Throwable $th) {
            return back()->with('error', 'Đã xảy ra lỗi trong quá trình xóa');
        }
    }
}
