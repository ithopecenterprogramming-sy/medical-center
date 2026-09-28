<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreClinicRequest;
use App\Http\Requests\Admin\UpdateClinicRequest;
use App\Http\Resources\Admin\ClinicResource;
use App\Models\Clinic;
use App\Services\Admin\ClinicService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;
use Throwable;

class ClinicController extends Controller
{
    use ApiResponse;

    public function __construct(protected ClinicService $clinicService) {}

    public function index(Request $request): JsonResponse
    {
        try {
            $clinics  = $this->clinicService->getAll($request->all());
            $resource = ClinicResource::collection($clinics)->response()->getData(true);

            return $this->successResponse($resource, 'تم جلب العيادات بنجاح.');
        } catch (Throwable $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function store(StoreClinicRequest $request): JsonResponse
    {
        try {
            $clinic = $this->clinicService->create($request->validated());

            return $this->createdResponse(new ClinicResource($clinic), 'تم إضافة العيادة وربطها بالقسم بنجاح.');
        } catch (Throwable $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $clinic = $this->clinicService->find($id);

            return $this->successResponse(new ClinicResource($clinic), 'تم جلب تفاصيل العيادة.');
        } catch (Throwable $e) {
            return $this->errorResponse('العيادة غير موجودة.', 404);
        }
    }

    public function update(UpdateClinicRequest $request, Clinic $clinic): JsonResponse
    {
        try {
            $updated = $this->clinicService->update($clinic, $request->validated());

            return $this->successResponse(new ClinicResource($updated), 'تم تحديث بيانات العيادة بنجاح.');
        } catch (Throwable $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function destroy(Clinic $clinic): JsonResponse
    {
        try {
            $this->clinicService->delete($clinic);

            return $this->successResponse(null, 'تم نقل العيادة إلى سلة المحذوفات بنجاح.');
        } catch (Exception $e) {
            if ($e->getCode() === 400) {
                return $this->badRequestResponse($e->getMessage());
            }
            return $this->errorResponse($e->getMessage(), 500);
        } catch (Throwable $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function restore(int $id): JsonResponse
    {
        try {
            $clinic = $this->clinicService->restore($id);

            return $this->successResponse(new ClinicResource($clinic), 'تم استعادة العيادة بنجاح.');
        } catch (Throwable $e) {
            return $this->errorResponse('العيادة المطلوبة غير موجودة في المحذوفات.', 404);
        }
    }

    public function forceDelete(int $id): JsonResponse
    {
        try {
            $this->clinicService->forceDelete($id);

            return $this->successResponse(null, 'تم حذف العيادة نهائياً من النظام.');
        } catch (Exception $e) {
            if ($e->getCode() === 400) {
                return $this->badRequestResponse($e->getMessage());
            }
            return $this->errorResponse($e->getMessage(), 500);
        } catch (Throwable $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}