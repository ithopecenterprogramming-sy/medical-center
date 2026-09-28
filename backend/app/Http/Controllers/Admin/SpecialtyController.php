<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSpecialtyRequest;
use App\Http\Requests\Admin\UpdateSpecialtyRequest;
use App\Http\Resources\Admin\SpecialtyResource;
use App\Models\Specialty;
use App\Services\Admin\SpecialtyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;
use Throwable;

class SpecialtyController extends Controller
{
    public function __construct(protected SpecialtyService $specialtyService) {}

    /**
     * عرض قائمة التخصصات
     * HTTP Status: 200 OK
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $specialties = $this->specialtyService->getAll($request->all());

            if ($specialties instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator) {
                return response()->json([
                    'success' => true,
                    'status_code' => 200,
                    'message' => 'تم جلب قائمة التخصصات بنجاح.',
                    'data' => SpecialtyResource::collection($specialties),
                    'pagination' => [
                        'total' => $specialties->total(),
                        'count' => $specialties->count(),
                        'per_page' => $specialties->perPage(),
                        'current_page' => $specialties->currentPage(),
                        'total_pages' => $specialties->lastPage(),
                    ]
                ], 200);
            }

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'تم جلب جميع التخصصات بنجاح.',
                'data' => SpecialtyResource::collection($specialties),
            ], 200);

        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    /**
     * إضافة تخصص جديد
     * HTTP Status: 201 Created
     */
    public function store(StoreSpecialtyRequest $request): JsonResponse
    {
        try {
            $specialty = $this->specialtyService->create($request->validated());

            return response()->json([
                'success' => true,
                'status_code' => 201,
                'message' => 'تم إضافة التخصص بنجاح.',
                'data' => new SpecialtyResource($specialty),
            ], 201);

        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    /**
     * عرض تفاصيل تخصص معين
     * HTTP Status: 200 OK
     */
    public function show(Specialty $specialty): JsonResponse
    {
        return response()->json([
            'success' => true,
            'status_code' => 200,
            'message' => 'تم عرض تفاصيل التخصص بنجاح.',
            'data' => new SpecialtyResource($specialty),
        ], 200);
    }

    /**
     * تحديث بيانات تخصص
     * HTTP Status: 200 OK
     */
    public function update(UpdateSpecialtyRequest $request, Specialty $specialty): JsonResponse
    {
        try {
            $updated = $this->specialtyService->update($specialty, $request->validated());

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'تم تحديث بيانات التخصص بنجاح.',
                'data' => new SpecialtyResource($updated),
            ], 200);

        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    /**
     * حذف تخصص (Soft Delete)
     * HTTP Status: 200 OK أو 202 Accepted عند المعالجة لاحقاً
     */
    public function destroy(Request $request, Specialty $specialty): JsonResponse
    {
        try {
            $forceDelete = filter_var($request->query('force'), FILTER_VALIDATE_BOOLEAN);
            $this->specialtyService->delete($specialty, $forceDelete);

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => $forceDelete ? 'تم حذف التخصص نهائياً من النظام.' : 'تم نقل التخصص إلى سلة المحذوفات.',
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 422,
                'message' => $e->getMessage(),
            ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 422);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }
    public function forceDelete(int $id): bool
    {
        // 1. البحث عن العنصر بما في ذلك المحذوفات مؤقتاً
        $specialty = Specialty::withTrashed()->findOrFail($id);

        // 2. التحقق من وجود أطباء مرتبطين قبل الحذف النهائي
        if ($specialty->doctorProfiles()->exists()) {
            throw new Exception("لا يمكن حذف التخصص نهائياً لأنه مرتبط بأطباء حاليين في النظام.", 422);
        }

        // 3. الحذف النهائي
        return $specialty->forceDelete();
    }
    /**
     * استعادة تخصص محذوف (Restore)
     * HTTP Status: 200 OK
     */
    public function restore(int $id): JsonResponse
    {
        try {
            $specialty = $this->specialtyService->restore($id);

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'تم استعادة التخصص المحذوف بنجاح.',
                'data' => new SpecialtyResource($specialty),
            ], 200);

        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }
    

    /**
     * معالجة الأخطاء غير المتوقعة وعرضها بحسب البيئة
     * HTTP Status: 500 Internal Server Error
     */
    private function handleException(Throwable $e): JsonResponse
    {
        return response()->json([
            'success' => false,
            'status_code' => 500,
            'message' => 'حدث خطأ غير متوقع في الخادم.',
            'error' => config('app.debug') ? $e->getMessage() : 'Internal Server Error'
        ], 500);
    }
}