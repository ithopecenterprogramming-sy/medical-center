<?php
namespace App\Services\Admin;

use App\Models\Specialty;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Exception;

class SpecialtyService
{
    public function getAll(array $filters = []): LengthAwarePaginator|Collection
    {
        $query = Specialty::query();

        // فلترة بالاسم
        if (!empty($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }

        // فلترة بالحالة
        if (isset($filters['is_active'])) {
            $query->where('is_active', filter_var($filters['is_active'], FILTER_VALIDATE_BOOLEAN));
        }

        // إمكانية طلب العناصر المحذوفة مؤقتاً
        if (isset($filters['with_trashed']) && filter_var($filters['with_trashed'], FILTER_VALIDATE_BOOLEAN)) {
            $query->withTrashed();
        }

        $perPage = $filters['per_page'] ?? 15;

        return (isset($filters['paginate']) && $filters['paginate'] === 'false')
            ? $query->latest()->get()
            : $query->latest()->paginate($perPage);
    }

    public function create(array $data): Specialty
    {
        return Specialty::create($data);
    }

    public function update(Specialty $specialty, array $data): Specialty
    {
        $specialty->update($data);
        return $specialty->refresh();
    }

    public function delete(Specialty $specialty, bool $forceDelete = false): bool
    {
        // التحقق من ارتباط التخصص بأطباء قبل الحذف النهائي
        if ($specialty) {
            if ($specialty->doctorProfiles()->exists()) {
                throw new Exception("لا يمكن حذف التخصص نهائياً لأنه مرتبط بأطباء حاليين في النظام.", 422);
            }
            return $specialty->delete();
        }

        return $specialty->delete(); // Soft Delete
    }
   public function forceDelete(int $id): bool
    {
        // 1. البحث عن التخصص بما في ذلك المحذوفات مؤقتاً (Soft Deleted)
        $specialty = Specialty::withTrashed()->findOrFail($id);

        // 2. التحقق من وجود أطباء مرتبطين بالتخصص قبل الحذف النهائي
        if ($specialty->doctorProfiles()->exists()) {
            throw new Exception("لا يمكن حذف التخصص نهائياً لأنه مرتبط بأطباء حاليين في النظام.", 422);
        }

        // 3. الحذف النهائي المباشر من الموديل
        return (bool) $specialty->forceDelete();
    }
   

    public function restore(int $id): Specialty
    {
        $specialty = Specialty::withTrashed()->findOrFail($id);
        $specialty->restore();
        return $specialty;
    }
}