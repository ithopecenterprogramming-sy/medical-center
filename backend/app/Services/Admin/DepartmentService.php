<?php
namespace App\Services\Admin;

use App\Models\Department;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Exception;

class DepartmentService
{
    /**
     * جلب كافة الأقسام مع التفلترة والصفحات
     */
    public function getAll(array $filters = []): LengthAwarePaginator|Collection
    {
        $query = Department::query()->withCount(['users', 'clinics']);

        if (!empty($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }

        if (isset($filters['is_active'])) {
            $query->where('is_active', filter_var($filters['is_active'], FILTER_VALIDATE_BOOLEAN));
        }

        if (!empty($filters['with_trashed'])) {
            $query->withTrashed();
        }

        $perPage = $filters['per_page'] ?? 15;
        $paginate = filter_var($filters['paginate'] ?? true, FILTER_VALIDATE_BOOLEAN);

        return $paginate ? $query->latest()->paginate($perPage) : $query->latest()->get();
    }

    /**
     * إنشاء قسم جديد
     */
    public function create(array $data): Department
    {
        return Department::create($data);
    }

    /**
     * جلب قسم بواسطة المعرف
     */
    public function find(int $id): Department
    {
        return Department::withCount(['users', 'clinics'])->findOrFail($id);
    }

    /**
     * تحديث بيانات قسم
     */
    public function update(Department $department, array $data): Department
    {
        $department->update($data);
        return $department->fresh();
    }

    /**
     * حذف مؤقت (Soft Delete)
     */
   public function delete(Department $department): bool
    {
        // التحقق من وجود عيادات أو أطباء مرتبطين قبل الحذف المؤقت
        if ($department->clinics()->exists() || $department->users()->exists()) {
            throw new Exception("لا يمكن نقل القسم إلى سلة المحذوفات لأنه مرتبط بعيادات أو أطباء حاليين.", 400);
        }

        return $department->delete();
    }

    /**
     * استعادة قسم محذوف مؤقتاً
     */
    public function restore(int $id): Department
    {
        $department = Department::withTrashed()->findOrFail($id);
        $department->restore();
        return $department;
    }

    /**
     * حذف نهائي مع التأكد من العلاقات
     */
    public function forceDelete(int $id): bool
    {
        $department = Department::withTrashed()->findOrFail($id);

        if ($department->users()->exists() || $department->clinics()->exists()) {
            throw new Exception("لا يمكن حذف القسم نهائياً لأنه مرتبط بمستخدمين أو عيادات حالية.", 400);
        }

        return $department->forceDelete();
    }
}