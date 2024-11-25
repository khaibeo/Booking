<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Services\ServiceService;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $getServiceCategoy = $this->serviceService->getServiceCategory();

        return view('admin.service.create', compact('getServiceCategoy'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceRequest $request)
    {
        try {
            $this->serviceService->createService($request->all());

            return redirect()->route('admin.services.index')->with('success', 'Thêm dịch vụ thành công');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $getServiceId = $this->serviceService->getServiceById($id);
        $getServiceCategoy = $this->serviceService->getServiceCategory();

        return view('admin.service.edit', compact('getServiceId', 'getServiceCategoy'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceRequest $request, string $id)
    {
        try {
            $this->serviceService->updateService($request->all(), $id);

            return redirect()->route('admin.services.index')->with('success', 'Cập nhật dịch vụ thành công');
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());

            return back()->with('error', 'Cập nhật dịch vụ thất bại');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->serviceService->deleteService($id);

            return redirect()->route('admin.services.index')->with('success', 'Xóa dịch vụ thành công');
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());

            return back()->with('error', 'Xóa dịch vụ thất bại');
        }
    }
}
