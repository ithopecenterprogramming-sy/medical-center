<?php
namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    /**
     * Success Response (200 OK)
     */
    public function successResponse(mixed $data = null, string $message = 'تمت العملية بنجاح.', int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'status_code' => $statusCode,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * Created Response (201 Created)
     */
    public function createdResponse(mixed $data = null, string $message = 'تم الإنشاء بنجاح.'): JsonResponse
    {
        return $this->successResponse($data, $message, 201);
    }

    /**
     * Bad Request Response (400 Bad Request)
     */
    public function badRequestResponse(string $message = 'طلب غير صالح.', mixed $errors = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'status_code' => 400,
            'message' => $message,
            'errors' => $errors,
        ], 400);
    }

    /**
     * Bad Gateway Response (502 Bad Gateway)
     */
    public function badGatewayResponse(string $message = 'خطأ في الاستجابة من السيرفر الوسيط (Bad Gateway).'): JsonResponse
    {
        return response()->json([
            'success' => false,
            'status_code' => 502,
            'message' => $message,
        ], 502);
    }

    /**
     * Exception / General Error Response
     */
    public function errorResponse(string $message = 'حدث خطأ في السيرفر.', int $statusCode = 500, mixed $errors = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'status_code' => $statusCode,
            'message' => $message,
            'errors' => $errors,
        ], $statusCode);
    }
}