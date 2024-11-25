<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Services\UserService;
use App\Traits\APIResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    use APIResponse;

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        try {
            $users = $this->userService->getListUser($request);

            return $this->responseSuccess(null, $users);
        } catch (\Exception $e) {
            return $this->responseServerError('Đã có lỗi xảy ra', $e->getMessage());
        }
    }

    public function store(StoreUserRequest $request)
    {
        try {
            $user = $this->userService->createUser($request->validated());

            return $this->responseCreated('Thêm thành công', $user);
        } catch (\Exception $e) {
            return $this->responseServerError('Đã có lỗi xảy ra', $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $user = $this->userService->getUserById($id);

            if (! $user) {
                return $this->responseNotFound(
                    Response::HTTP_NOT_FOUND,
                    'Không tìm người dùng',

                );
            }

            return $this->responseSuccess(null, $user);
        } catch (\Exception $e) {
            return $this->responseServerError('Đã có lỗi xảy ra', $e->getMessage());
        }
    }

    public function update(StoreUserRequest $request, $id)
    {
        try {
            $user = $this->userService->getUserById($id);

            if (! $user) {
                return $this->responseNotFound(
                    Response::HTTP_NOT_FOUND,
                    'Không tìm thấy người dùng',
                );
            }

            $user = $this->userService->updateUser($id, $request->validated());

            return $this->responseSuccess('Cập nhật thành công', $user);
        } catch (\Exception $e) {
            return $this->responseServerError('Đã có lỗi xảy ra', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $user = $this->userService->getUserById($id);

            if (! $user) {
                return $this->responseNotFound(
                    Response::HTTP_NOT_FOUND,
                    'Không tìm thấy người dùng',
                );
            }

            $this->userService->deleteUser($user);

            return $this->responseDeleted();
        } catch (\Exception $e) {
            return $this->responseServerError('Đã có lỗi xảy ra', $e->getMessage());
        }
    }
}
