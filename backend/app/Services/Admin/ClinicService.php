<?php
namespace App\Services\Admin;

use App\Models\Clinic;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Exception;

class ClinicService
{
    /**
     * جلب كافة العيادات مع التفلترة
     */
    public function getAll(array $filters = []): LengthAwarePaginator|Collection
    {
        $query = Clinic::query()->with(['department'])->withCount('doctors');

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('room_number', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (!empty($filters['department_id'])) {
            $query->where('department_id', $filters['department_id']);
        }

        if (isset($filters['is_active'])) {
            $query->where('is_active', filter_var($filters['is_active'], FILTER_VALIDATE_BOOLEAN));
        }

        if (!empty($filters['with_trashed'])) {
            $query->withTrashed();
        }

        $perPage  = $filters['per_page'] ?? 15;
        $paginate = filter_var($filters['paginate'] ?? true, FILTER_VALIDATE_BOOLEAN);

        return $paginate ? $query->latest()->paginate($perPage) : $query->latest()->get();
    }

    /**
     * إنشاء عيادة جديدة وتأكيد ربطها بالقسم
     */
    public function create(array $data): Clinic
    {
        $clinic = Clinic::create($data);
        return $clinic->load('department');
    }

    /**
     * جلب عيادة بواسطة المعرف
     */
    public function find(int $id): Clinic
    {
        return Clinic::with(['department'])->withCount('doctors')->findOrFail($id);
    }

    /**
     * تحديث بيانات العيادة والقسم المرتبط بها
     */
    public function update(Clinic $clinic, array $data): Clinic
    {
        $clinic->update($data);
        return $clinic->fresh(['department']);
    }

    /**
     * الحذف المؤقت (Soft Delete)
     */
    public function delete(Clinic $clinic): bool
    {
        if ($clinic->appointments()->exists() || $clinic->visits()->exists()) {
            throw new Exception("لا يمكن نقل العيادة إلى سلة المحذوفات لارتباطها بمواعيد أو زيارات قائمة.", 400);
        }

        return $clinic->delete();
    }

    /**
     * استعادة عيادة محذوفة مؤقتاً
     */
    public function restore(int $id): Clinic
    {
        $clinic = Clinic::withTrashed()->findOrFail($id);
        $clinic->restore();
        return $clinic->load('department');
    }

    /**
     * الحذف النهائي للعيادة
     */
    public function forceDelete(int $id): bool
    {
        $clinic = Clinic::withTrashed()->findOrFail($id);

        if ($clinic->appointments()->exists() || $clinic->visits()->exists() || $clinic->doctors()->exists()) {
            throw new Exception("لا يمكن حذف العيادة نهائياً لارتباطها بسجلات في النظام (أطباء، مواعيد، أو زيارات).", 400);
        }

        return $clinic->forceDelete();
    }
}