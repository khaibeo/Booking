<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Models\Service;
use App\Services\ServiceService;

class ServiceController extends Controller
{
    protected $serviceService;

    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }

    public function index()
    {
        $services = $this->serviceService->getAllService();

        return view('admin.service.index', compact('services'));
    }

    public function create()
    {
        $this->authorize('create', Service::class);

        $serviceCategories = $this->serviceService->getServiceCategory();

        return view('admin.service.create', compact('serviceCategories'));
    }

    public function store(ServiceRequest $request)
    {
        try {
            $this->serviceService->createService($request->validated());

            return redirect()->route('admin.services.index')->with('success', 'Thêm dịch vụ thành công');
        } catch (\Throwable $th) {
            return back()->with('error', 'Đã có lỗi xảy ra');
        }
    }

    public function edit(Service $service)
    {
        $this->authorize('update', $service);

        $serviceCategories = $this->serviceService->getServiceCategory();

        return view('admin.service.edit', compact('service', 'serviceCategories'));
    }

    public function update(ServiceRequest $request, Service $service)
    {
        try {
            $this->serviceService->updateService($request->validated(), $service);

            return redirect()->route('admin.services.index')->with('success', 'Cập nhật dịch vụ thành công');
        } catch (\Throwable $th) {
            return back()->with('error', 'Đã có lỗi xảy ra');
        }
    }

    public function destroy(Service $service)
    {
        $this->authorize('delete', $service);

        try {
            $this->serviceService->deleteService($service);

            return redirect()->route('admin.services.index')->with('success', 'Xóa dịch vụ thành công');
        } catch (\Throwable $th) {
            return back()->with('error', 'Đã có lỗi xảy ra');
        }
    }
}
