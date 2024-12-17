<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

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
            'admin' => redirect()->route('admin.dashboard'),
            'manager' => redirect()->route('admin.dashboard'),
            'staff' => redirect()->route('admin.staff.dashboard'),
            'cashier' => redirect()->route('cashier.dashboard'),
        };
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['success' => 'Email đã được gửi'])
            : back()->withErrors(['email' => 'Email không chính xác']);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Đặt lại mật khẩu thành công')
            : back()->withErrors(['email' => 'Email không chính xác']);
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request);

        return redirect()->route('login');
    }
}
