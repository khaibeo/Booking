<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $user = $request->user();

        // Nếu người dùng là admin, cho phép truy cập tất cả
        if ($user->role === 'manager') {
            return $next($request);
        }

        // Kiểm tra quyền truy cập dựa trên vai trò khác
        if ($user->role !== $role && $role !== 'all') {
            return redirect()->route('admin.dashboard')->with('error', 'Bạn không có quyền truy cập vào trang này.');
        }

        return $next($request);
    }
}
