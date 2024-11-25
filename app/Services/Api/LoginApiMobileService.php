<?php

namespace App\Services\Api;

use App\Models\User;
use App\Traits\APIResponse;
use Exception;
use Illuminate\Support\Facades\Auth;

class LoginApiMobileService
{
    use APIResponse;

    public function checkLogin($request)
    {
        $user = User::where('email', $request->email)->first();
        if (! $user) {
            throw new Exception('Tài khoản không tồn tại');
        }
        if ($user->locked_at <= now() || Auth::attempt($request->validated())) {
            $user->locked_at = null;
            $user->login_attempts = 0;
            $user->save();
        }
        if ($user->login_attempts >= 5) {
            $user->locked_at = now()->addMinutes(5);
            $user->save();
            throw new Exception('Tài khoản đã bị khóa do nhập sai quá nhiều lần.Vui lòng thử lại sau 5 phút');
        }
    }
}
