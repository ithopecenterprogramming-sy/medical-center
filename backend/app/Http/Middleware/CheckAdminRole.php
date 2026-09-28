<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. التحقق من أن المستخدم مسجل الدخول
        if (! $request->user()) {
            return response()->json([
                'success' => false,
                'status_code' => 401,
                'message' => 'غير مصرح لك بالوصول، يرجى تسجيل الدخول أولاً.',
            ], 401);
        }

        // 2. التحقق من أن دور المستخدم هو أدمن (admin)
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'status_code' => 403,
                'message' => 'عذراً، لا تمتلك الصلاحيات الكافية للوصول لهذا المورد.',
            ], 403);
        }

        return $next($request);
    }
}