<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Models\Service;
use App\Services\ServiceManager;
use Exception;
use Illuminate\Http\JsonResponse;

class ServiceController extends Controller
{
    protected $serviceManager;

    public function __construct(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    /**
     * Hiển thị danh sách dịch vụ.
     */
    public function index(): JsonResponse
    {
        try {
            $services = $this->serviceManager->getAllServices();

            return response()->json(['status' => 'success', 'data' => $services], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Thêm mới dịch vụ.
     */
    public function store(ServiceRequest $request): JsonResponse
    {
        try {
            $service = $this->serviceManager->createService($request->validated());

            return response()->json(['status' => 'success', 'message' => 'Dịch vụ đã được thêm mới thành công!', 'data' => $service], 201);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Hiển thị chi tiết dịch vụ.
     */
    public function show(Service $service): JsonResponse
    {
        return response()->json(['status' => 'success', 'data' => $service], 200);
    }

    /**
     * Cập nhật dịch vụ.
     */
    public function update(ServiceRequest $request, Service $service): JsonResponse
    {
        try {
            $updatedService = $this->serviceManager->updateService($service, $request->validated());

            return response()->json(['status' => 'success', 'message' => 'Dịch vụ đã được cập nhật thành công!', 'data' => $updatedService], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Xóa dịch vụ.
     */
    public function destroy(Service $service): JsonResponse
    {
        try {
            $this->serviceManager->deleteService($service);

            return response()->json(['status' => 'success', 'message' => 'Dịch vụ đã được xóa thành công!'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
