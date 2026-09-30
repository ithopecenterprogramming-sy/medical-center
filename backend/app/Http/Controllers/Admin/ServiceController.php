<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreServiceRequest;
use App\Http\Requests\Admin\UpdateServiceRequest;
use App\Http\Resources\Admin\ServiceResource;
use App\Models\Service;
use App\Services\Admin\MedicalService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;
use Throwable;

class ServiceController extends Controller
{
    use ApiResponseTrait;

    public function __construct(protected MedicalService $medicalService) {}

    public function index(Request $request): JsonResponse
    {
        try {
            $services = $this->medicalService->getAll($request->all());

            if ($services instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator) {
                return $this->successWithPagination($services, ServiceResource::class, 'تم جلب قائمة الخدمات بنجاح.');
            }

            return $this->successResponse(
                ServiceResource::collection($services),
                'تم جلب جميع الخدمات بنجاح.'
            );
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function store(StoreServiceRequest $request): JsonResponse
    {
        try {
            $service = $this->medicalService->create($request->validated());

            return $this->successResponse(
                new ServiceResource($service),
                'تم إضافة الخدمة بنجاح.',
                201
            );
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function show(Service $service): JsonResponse
    {
        return $this->successResponse(
            new ServiceResource($service->load('serviceType')),
            'تم عرض تفاصيل الخدمة بنجاح.'
        );
    }

    public function update(UpdateServiceRequest $request, Service $service): JsonResponse
    {
        try {
            $updated = $this->medicalService->update($service, $request->validated());

            return $this->successResponse(
                new ServiceResource($updated),
                'تم تحديث بيانات الخدمة بنجاح.'
            );
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function destroy(Service $service): JsonResponse
    {
        try {
            $this->medicalService->delete($service);

            return $this->successResponse(null, 'تم نقل الخدمة إلى سلة المحذوفات.');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 422);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function forceDelete(int $id): JsonResponse
    {
        try {
            $this->medicalService->forceDelete($id);

            return $this->successResponse(null, 'تم حذف الخدمة نهائياً من النظام.');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 422);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function restore(int $id): JsonResponse
    {
        try {
            $restored = $this->medicalService->restore($id);

            return $this->successResponse(
                new ServiceResource($restored),
                'تم استعادة الخدمة بنجاح.'
            );
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }
}