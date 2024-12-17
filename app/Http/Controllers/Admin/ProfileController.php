<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Admin\UpdateProfileRequest;
use App\Models\User;
use App\Services\UserService;

class ProfileController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function show(User $user)
    {
        $this->authorize('viewProfile', $user);

        return view('admin.users.profile', compact('user'));
    }

    public function update(UpdateProfileRequest $request, User $user)
    {
        $this->authorize('viewProfile', $user);

        $data = $request->validated();

        try {
            $this->userService->update($user, $data);

            return back()->with('success', 'Cập nhật thành công');
        } catch (\Throwable $th) {
            dd($th->getMessage());

            return back()->with('error', 'Đã có lỗi xảy ra');
        }
    }

    public function changePassword(ChangePasswordRequest $request, User $user)
    {
        $data = $request->validated();

        try {
            $check = $this->userService->checkPassword($user, $data['old_password']);

            if (! $check) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dữ liệu không hợp lệ!',
                    'errors' => ['old_password' => ['Mật khẩu hiện tại không chính xác']],
                ]);
            }

            $this->userService->changePassword($user, $data['new_password']);

            return response()->json([
                'success' => true,
                'message' => 'Đổi mật khẩu thành công',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Đã có lỗi xảy ra',
                'errors' => $th->getMessage(),
            ]);
        }
    }
}
