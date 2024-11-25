<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request)
    {
        $email = $request->validated('email');

        // Kiểm tra xem tài khoản có tồn tại hay không
        if (! $this->authService->isUserExist($email)) {
            return back()->withErrors([
                'email' => 'Tài khoản hoặc mật khẩu không chính xác',
            ])->onlyInput('email');
        }

        // Kiểm tra xem tài khoản có bị khóa không
        if ($this->authService->isUserLocked($email)) {
            return back()->withErrors([
                'email' => 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản trị viên',
            ])->onlyInput('email');
        }

        // Kiểm tra đăng nhập
        if (! $this->authService->login($request)) {
            return back()->withErrors([
                'email' => 'Tài khoản hoặc mật khẩu không chính xác',
            ])->onlyInput('email');
        }

        // Chuyển hướng theo vai trò người dùng khi đăng nhập thành công
        $userRole = Auth::user()->role;

        return match ($userRole) {
            'manager' => redirect()->route('admin.dashboard'),
            'staff' => redirect()->route('admin.staff.dashboard'),
            'cashier' => redirect()->route('cashier.dashboard'),
        };
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request);

        return redirect()->route('login');
    }
}
