<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Models\ServiceCategory;
use App\Services\CategoryService;

class ServiceCategoryController extends Controller
{
    protected $serviceCategoryService;

    public function __construct(CategoryService $serviceCategoryService)
    {
        $this->serviceCategoryService = $serviceCategoryService;
    }

    public function index()
    {
        $serviceCategories = $this->serviceCategoryService->getAllCategories();

        return view('admin.serviceCategory.index', compact('serviceCategories'));
    }

    public function create()
    {
        $this->authorize('create', ServiceCategory::class);
        return view('admin.serviceCategory.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        try {
            $this->serviceCategoryService->storeCategory($request->all());

            return redirect()->route('admin.service-category.index');
        } catch (\Throwable $th) {
            return back()->with('error', 'Đã có lỗi xảy ra');
        }
    }

    public function edit(ServiceCategory $service_category)
    {
        $this->authorize('update', $service_category);

        return view('admin.serviceCategory.edit', compact('service_category'));
    }

    public function update(StoreCategoryRequest $request, ServiceCategory $service_category)
    {
        try {
            $this->serviceCategoryService->updateCategory($service_category, $request->validated());

            return redirect()->route('admin.service-category.index')->with('success', 'Cập nhật thành công');
        } catch (\Throwable $th) {
            return back()->with('error', 'Đã có lỗi xảy ra');
        }
    }

    public function destroy(ServiceCategory $service_category)
    {
        $this->authorize('delete', $service_category);

        try {
            $check = $this->serviceCategoryService->checkService($service_category);

            if ($check) {
                return back()->with('error', 'Danh mục đang có dịch vụ, không thể xóa !');
            }

            $this->serviceCategoryService->deleteCategory($service_category);

            return back()->with('success', 'Xóa thành công');
        } catch (\Throwable $th) {
            return back()->with('error', 'Đã có lỗi xảy ra');
        }
    }
}
