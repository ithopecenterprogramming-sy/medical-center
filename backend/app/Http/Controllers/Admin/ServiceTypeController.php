<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreServiceTypeRequest;
use App\Http\Requests\Admin\UpdateServiceTypeRequest;
use App\Http\Resources\Admin\ServiceTypeResource;
use App\Models\ServiceType;
use App\Services\Admin\ServiceTypeService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;
use Throwable;

class ServiceTypeController extends Controller
{
    use ApiResponseTrait;

    public function __construct(protected ServiceTypeService $serviceTypeService) {}

    public function index(Request $request): JsonResponse
    {
        try {
            $types = $this->serviceTypeService->getAll($request->all());

            if ($types instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator) {
                return $this->successWithPagination($types, ServiceTypeResource::class, 'تم جلب أنواع الخدمات بنجاح.');
            }

            return $this->successResponse(
                ServiceTypeResource::collection($types),
                'تم جلب جميع أنواع الخدمات بنجاح.'
            );
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function store(StoreServiceTypeRequest $request): JsonResponse
    {
        try {
            $serviceType = $this->serviceTypeService->create($request->validated());

            return $this->successResponse(
                new ServiceTypeResource($serviceType),
                'تم إضافة نوع الخدمة بنجاح.',
                201
            );
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function show(ServiceType $serviceType): JsonResponse
    {
        return $this->successResponse(
            new ServiceTypeResource($serviceType),
            'تم عرض تفاصيل نوع الخدمة بنجاح.'
        );
    }

    public function update(UpdateServiceTypeRequest $request, ServiceType $serviceType): JsonResponse
    {
        try {
            $updated = $this->serviceTypeService->update($serviceType, $request->validated());

            return $this->successResponse(
                new ServiceTypeResource($updated),
                'تم تحديث بيانات نوع الخدمة بنجاح.'
            );
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function destroy(ServiceType $serviceType): JsonResponse
    {
        try {
            $this->serviceTypeService->delete($serviceType);

            return $this->successResponse(null, 'تم نقل نوع الخدمة إلى سلة المحذوفات.');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 422);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function forceDelete(int $id): JsonResponse
    {
        try {
            $this->serviceTypeService->forceDelete($id);

            return $this->successResponse(null, 'تم حذف نوع الخدمة نهائياً من النظام.');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 422);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function restore(int $id): JsonResponse
    {
        try {
            $restored = $this->serviceTypeService->restore($id);

            return $this->successResponse(
                new ServiceTypeResource($restored),
                'تم استعادة نوع الخدمة بنجاح.'
            );
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }
}