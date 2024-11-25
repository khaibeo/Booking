<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class ServiceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.serviceCategory.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        try {
            $this->serviceCategoryService->storeCategory($request->all());

            return redirect()->route('admin.services_category.index');
        } catch (\Throwable $th) {
            dd($th->getMessage());

            return redirect()->back();
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
        $serviceCategoryId = $this->serviceCategoryService->loadIdCategory($id);

        return view('admin.serviceCategory.edit', compact('serviceCategoryId'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $this->serviceCategoryService->updateCategory($id, $request->all());

            return redirect()->route('admin.services_category.index')->with('success', 'Cập nhật thành công');
        } catch (\Throwable $th) {
            dd($th->getMessage());

            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $check = $this->serviceCategoryService->checkService($id);

            if ($check) {
                return back()->with('error', 'Danh mục đang có dịch vụ, không thể xóa !');
            }

            $this->serviceCategoryService->deleteCategory($id);

            return back()->with('success', 'Xóa thành công');
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
