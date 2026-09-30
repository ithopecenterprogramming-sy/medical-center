<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\AuditLog;
use App\Traits\ApiResponse;

 class AuthController extends Controller
{
    use ApiResponse;
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

            $user = $result['user'];

            // تسجيل حدث تسجيل الدخول بنجاح في جدول audit_logs
           // عند تسجيل الدخول (login)
            AuditLog::create([
                'user_id'    => $user->id,
                'name'       => $user->name,
                'notes'      => "قام {$user->name} بتسجيل الدخول إلى النظام.",
                'action'     => 'login',
                'route'      => $request->path(),
                'method'     => $request->method(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'created_at' => now(),
            ]);

            return $this->successResponse([
                'user'  => new UserResource($user),
                'token' => $result['token'],
            ], 'تم تسجيل الدخول بنجاح.');

        } catch (\Illuminate\Auth\AuthenticationException $e) {
            // فشل في تطابق البريد أو كلمة المرور
            RateLimiter::hit($throttleKey, 300);

            return $this->errorResponse('بيانات الدخول غير صحيحة.', 401);

        } catch (Throwable $e) {
            return $this->errorResponse('حدث خطأ في السيرفر أثناء تسجيل الدخول.', 500, config('app.debug') ? $e->getMessage() : null);
        }
    }
    /**
     * Logout current user.
     */
    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user) {
            // تسجيل حدث تسجيل الخروج في جدول audit_logs قبل إبطال التوكن
            // عند تسجيل الخروج (logout)
            AuditLog::create([
                'user_id'    => $user->id,
                'name'       => $user->name,
                'notes'      => "قام {$user->name} بتسجيل الخروج من النظام.",
                'action'     => 'logout',
                'route'      => $request->path(),
                'method'     => $request->method(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'created_at' => now(),
            ]);

            $this->authService->logout($user);
        }

        return $this->successResponse(null, 'تم تسجيل الخروج بنجاح.');
    }

    /**
     * Get authenticated user profile.
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user();

        if (! $user) {
            return $this->errorResponse('Unauthenticated or invalid token.', 401);
        }

        return $this->successResponse(new UserResource($user), 'User profile retrieved successfully.');
    }
}