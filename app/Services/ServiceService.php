<?php

namespace App\Services;

use App\Models\Service;
use App\Models\ServiceCategory;

class ServiceService
{
    public function getAllService()
    {
        return Service::query()->with('category')->orderBy('created_at', 'desc')->paginate(10);
    }

    public function getServiceById($id)
    {
        return Service::query()->with('category')->find($id);
    }

    public function getServiceCategory()
    {
        return ServiceCategory::query()->get();
    }

    public function createService(array $request)
    {
        return Service::query()->create($request);
    }

    public function updateService(array $data, $service)
    {
        return $service->update($data);
    }

    public function deleteService($service)
    {
        return $service->delete();
    }
}
