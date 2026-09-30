<?php

namespace App\Services\Admin;

use App\Models\ServiceType;
use Exception;

class ServiceTypeService
{
    public function getAll(array $filters = [])
    {
        $query = ServiceType::query();

        if (!empty($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }

        if (isset($filters['is_active'])) {
            $query->where('is_active', filter_var($filters['is_active'], FILTER_VALIDATE_BOOLEAN));
        }

        $query->orderBy('id', 'desc');

        return isset($filters['per_page']) 
            ? $query->paginate((int) $filters['per_page']) 
            : $query->get();
    }

    public function create(array $data): ServiceType
    {
        return ServiceType::create($data);
    }

    public function update(ServiceType $serviceType, array $data): ServiceType
    {
        $serviceType->update($data);
        return $serviceType->refresh();
    }

    public function delete(ServiceType $serviceType): bool
    {
        if ($serviceType->services()->exists()) {
            throw new Exception("لا يمكن نقل نوع الخدمة للسلة لأنه مرتبط بخدمات حالية في النظام.", 422);
        }

        return (bool) $serviceType->delete();
    }

    public function forceDelete(int $id): bool
    {
        $serviceType = ServiceType::withTrashed()->findOrFail($id);

        if ($serviceType->services()->exists()) {
            throw new Exception("لا يمكن حذف نوع الخدمة نهائياً لأنه مرتبط بخدمات حالية في النظام.", 422);
        }

        return (bool) $serviceType->forceDelete();
    }

    public function restore(int $id): ServiceType
    {
        $serviceType = ServiceType::withTrashed()->findOrFail($id);
        $serviceType->restore();
        
        return $serviceType;
    }
}