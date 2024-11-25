<?php

namespace App\Services;

use App\Models\Service;
use Exception;

class ServiceManager
{
    /**
     * Lấy danh sách dịch vụ.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllServices()
    {
        return Service::with('category')->get();
    }

    /**
     * Thêm mới dịch vụ.
     *
     * @throws Exception
     */
    public function createService(array $data): Service
    {
        return Service::create($data);
    }

    /**
     * Cập nhật dịch vụ.
     *
     * @throws Exception
     */
    public function updateService(Service $service, array $data): Service
    {
        $service->update($data);

        return $service;
    }

    /**
     * Xóa dịch vụ.
     *
     * @throws Exception
     */
    public function deleteService(Service $service): void
    {
        try {
            $service->delete();
        } catch (Exception $e) {
            throw new Exception('Không thể xóa dịch vụ: '.$e->getMessage());
        }
    }
}
