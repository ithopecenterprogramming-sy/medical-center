<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
 class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $authService
    ) {
    }

    /**
     * Login user.
     */
  

public function login(LoginRequest $request): JsonResponse
{
    $email = $request->string('email')->toString();
    $password = $request->string('password')->toString();

    // 1. تحديد مفتاح الحظر (البريد الإلكتروني + عنوان الـ IP)
    $throttleKey = mb_strtolower($email) . '|' . $request->ip();

    // 2. التحقق مما إذا كان المستخدم محظوراً حالياً (مثلاً بعد 5 محاولات فاشلة)
    if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
        // قراءة الثواني المتبقية الحقيقية دون إضافة محاولة جديدة (حتى لا يتم تصفير العداد)
        $seconds = RateLimiter::availableIn($throttleKey);

        return response()->json([
            'success' => false,
            'message' => 'محاولات كثيرة متكررة، يرجى الانتظار حتى انتهاء العداد.',
        ], 429, [
            'Retry-After' => $seconds, // يُرجع الثواني المتبقية الفعلية للفرونت إند
        ]);
    }

    try {
        // 3. تنفيذ عملية تسجيل الدخول عبر الـ Service
        $result = $this->authService->login($email, $password);

        // 4. في حال نجاح الدخول: مسح سجل المحاولات الفاشلة للمستخدم
        RateLimiter::clear($throttleKey);

        return response()->json([
            'success' => true,
            'message' => 'Login successful.',
            'data' => [
                'user' => new UserResource($result['user']),
                'token' => $result['token'],
            ],
        ], 200);

    } catch (\Exception $e) {
        // 5. في حال فشل تسجيل الدخول (كلمة مرور خطأ مثلاً): تسجيل محاولة فاشلة بمدة حظر 5 دقائق (300 ثانية)
        RateLimiter::hit($throttleKey, 300);

        // إعادة إرجاع استجابة الخطأ (أو ترك الـ ExceptionHandler يتعامل معها)
        return response()->json([
            'success' => false,
            'message' => 'بيانات الدخول غير صحيحة.',
        ], 401);
    }
}
    /**
     * Logout current user.
     */
    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());

        return response()->json([
            'success' => true,
            'message' => 'Logout successful.',
        ], 200);
    }

    /**
     * Get authenticated user profile.
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated or invalid token.',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'User profile retrieved successfully.',
            'data' => new UserResource($user),
        ], 200);
    }
}