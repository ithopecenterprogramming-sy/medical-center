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

    $throttleKey = mb_strtolower($email) . '|' . $request->ip();

    if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
        $seconds = RateLimiter::availableIn($throttleKey);

        return response()->json([
            'success' => false,
            'message' => 'محاولات كثيرة متكررة، يرجى الانتظار حتى انتهاء العداد.',
        ], 429, [
            'Retry-After' => $seconds,
        ]);
    }

    try {
        $result = $this->authService->login($email, $password);

        RateLimiter::clear($throttleKey);

        return response()->json([
            'success' => true,
            'message' => 'Login successful.',
            'data' => [
                'user' => new UserResource($result['user']),
                'token' => $result['token'],
            ],
        ], 200);

    } catch (\Illuminate\Auth\AuthenticationException $e) {
        // فشل في تطابق البريد أو كلمة المرور
        RateLimiter::hit($throttleKey, 300);

        return response()->json([
            'success' => false,
            'message' => 'بيانات الدخول غير صحيحة.',
        ], 401);

    } catch (\Throwable $e) {
        // خطأ سيرفر أو استثناء غير متوقع داخل الـ AuthService
        return response()->json([
            'success' => false,
            'message' => 'حدث خطأ في السيرفر أثناء تسجيل الدخول.',
            'error' => config('app.debug') ? $e->getMessage() : null,
        ], 500);
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