<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthService
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $email = $credentials['email'];

        $remember = $request->has('remember-me') == 1 ? true : false;

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Reset số lần đăng nhập sai
            $this->resetLoginAttempts($email);

            return true;
        }

        // Đăng nhập thất bại, tăng số lần đăng nhập sai
        $this->incrementLoginAttempts($email);

        // Kiểm tra số lần đăng nhập sai
        $attempts = $this->getLoginAttempts($email);

        // Nếu sai trên 5 lần thì khóa tài khoản
        if ($attempts >= 5) {
            $this->lockUser($email);
        }

        return false;
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
    }

    public function isUserExist($email)
    {
        $user = User::where('email', $email)->first();

        if ($user) {
            return true;
        }

        return false;
    }

    public function isUserLocked($email)
    {
        $user = User::where('email', $email)->first();

        if ($user->is_locked) {
            return true;
        }

        return false;
    }

    public function resetLoginAttempts($email)
    {
        DB::table('login_attempts')->where('email', $email)->delete();
    }

    public function incrementLoginAttempts($email)
    {
        DB::table('login_attempts')->updateOrInsert(
            ['email' => $email],
            ['attempts' => DB::raw('attempts + 1'), 'last_attempt_at' => now()]
        );
    }

    public function getLoginAttempts($email)
    {
        $record = DB::table('login_attempts')->where('email', $email)->first();

        return $record ? $record->attempts : 0;
    }

    public function lockUser($email)
    {
        DB::table('users')->where('email', $email)->update(['is_locked' => true]);
    }
}
