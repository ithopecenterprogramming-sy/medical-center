<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDepartmentRequest;
use App\Http\Requests\Admin\UpdateDepartmentRequest;
use App\Http\Resources\Admin\DepartmentResource;
use App\Models\Department;
use App\Services\Admin\DepartmentService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;
use Throwable;

class DepartmentController extends Controller
{
    use ApiResponse;

    public function __construct(protected DepartmentService $departmentService) {}

    public function index(Request $request): JsonResponse
    {
        try {
            $departments = $this->departmentService->getAll($request->all());
            $resource = DepartmentResource::collection($departments)->response()->getData(true);

            return $this->successResponse($resource, 'تم جلب الأقسام بنجاح.');
        } catch (Throwable $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function store(StoreDepartmentRequest $request): JsonResponse
    {
        try {
            $department = $this->departmentService->create($request->validated());

            return $this->createdResponse(new DepartmentResource($department), 'تم إضافة القسم بنجاح.');
        } catch (Throwable $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $department = $this->departmentService->find($id);

            return $this->successResponse(new DepartmentResource($department), 'تم جلب تفاصيل القسم.');
        } catch (Throwable $e) {
            return $this->errorResponse('القسم غير موجود.', 404);
        }
    }

    public function update(UpdateDepartmentRequest $request, Department $department): JsonResponse
    {
        try {
            $updated = $this->departmentService->update($department, $request->validated());

            return $this->successResponse(new DepartmentResource($updated), 'تم تحديث القسم بنجاح.');
        } catch (Throwable $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function destroy(Department $department): JsonResponse
    {
        try {
            $this->departmentService->delete($department);

            return $this->successResponse(null, 'تم نقل القسم إلى سلة المحذوفات بنجاح.');
        } catch (Throwable $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function restore(int $id): JsonResponse
    {
        try {
            $department = $this->departmentService->restore($id);

            return $this->successResponse(new DepartmentResource($department), 'تم استعادة القسم بنجاح.');
        } catch (Throwable $e) {
            return $this->errorResponse('القسم المطلوب غير موجود في المحذوفات.', 404);
        }
    }

    public function forceDelete(int $id): JsonResponse
    {
        try {
            $this->departmentService->forceDelete($id);

            return $this->successResponse(null, 'تم حذف القسم نهائياً من النظام.');
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