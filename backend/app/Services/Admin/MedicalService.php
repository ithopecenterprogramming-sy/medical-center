<?php

namespace App\Services\Admin;

use App\Models\Service;
use Exception;

class MedicalService
{
    public function getAll(array $filters = [])
    {
        $query = Service::with('serviceType');

        if (!empty($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }

        if (!empty($filters['service_type_id'])) {
            $query->where('service_type_id', $filters['service_type_id']);
        }

        if (isset($filters['is_active'])) {
            $query->where('is_active', filter_var($filters['is_active'], FILTER_VALIDATE_BOOLEAN));
        }

        $query->orderBy('id', 'desc');

        return isset($filters['per_page']) 
            ? $query->paginate((int) $filters['per_page']) 
            : $query->get();
    }

    public function create(array $data): Service
    {
        $service = Service::create($data);
        return $service->load('serviceType');
    }

    public function update(Service $service, array $data): Service
    {
        $service->update($data);
        return $service->refresh()->load('serviceType');
    }

    public function delete(Service $service): bool
    {
        return (bool) $service->delete();
    }

    public function forceDelete(int $id): bool
    {
        $service = Service::withTrashed()->findOrFail($id);
        return (bool) $service->forceDelete();
    }

    public function restore(int $id): Service
    {
        $service = Service::withTrashed()->findOrFail($id);
        $service->restore();

        return $service->load('serviceType');
    }
}