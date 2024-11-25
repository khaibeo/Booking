<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginApiMobileController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        try {
            $this->LoginApiMobileService->checkLogin($request);
            if (! Auth::attempt($request->validated())) {
                $user->increment('login_attempts');

                return $this->responseBadRequest(null, 'Đăng nhập thất bại vui long kiểm tra lại . Vui lòng kiểm tra lại tài khoản hoặc mật khẩu !');
            }
            $token = $request->user()->createToken('auth')->plainTextToken;

            return $this->responseSuccess('Đăng nhập thành công', [
                'token' => $token,
            ]);
        } catch (\Exception $e) {
            return $this->responseBadRequest($e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();
        }
        Session::flush();

        return $this->responseSuccess('Đăng xuất thành công');
    }

    public function profile(Request $req)
    {
        return $this->responseSuccess('Profile successfully', $req->user());
    }
}
