<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    const PATH_VIEW = 'admin.categories.';

    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    // Hiển thị danh sách categoryService
    public function index()
    {
        $categories = $this->categoryService->getAllCategories();

        return view(self::PATH_VIEW.__FUNCTION__, compact('categories'));
    }

    public function create()
    {
        return view(self::PATH_VIEW.__FUNCTION__);
    }

    public function store(StoreCategoryRequest $request)
    {
        try {
            $this->categoryService->storeCategory($request->validated());

            return redirect()->route('admin.categories.index')->with('success', 'Thêm mới danh mục thành công');
        } catch (\Throwable $th) {
            return redirect()->route('admin.categories.index')->with('error', 'Đã có lỗi xảy ra. Vui lòng thử lại !');
        }
    }

    public function edit($id)
    {
        $categoryService = $this->categoryService->loadIdCategory($id);

        return view(self::PATH_VIEW.__FUNCTION__, compact('categoryService'));
    }

    public function update(StoreCategoryRequest $request, $id)
    {
        try {
            $this->categoryService->updateCategory($id, $request->validated());

            return redirect()->route('admin.categories.index')->with('success', 'Cập nhật thành công');
        } catch (\Throwable $th) {
            return back()->with('error', 'Có lỗi xảy ra. Vui lòng  thao tác');
        }
    }

    // Xóa mềm một bản ghi categoryService
    public function destroy($id)
    {
        // Tìm ServiceCategory bằng ID
        $categoryService = $this->categoryService->loadIdCategory($id);

        // Sử dụng policy để kiểm tra quyền
        $this->authorize('delete', $categoryService);

        $result = $this->categoryService->deleteCategory($id);

        if ($result) {
            return redirect()->route('admin.categories.index')->with('success', 'Xóa danh mục thành công');
        } else {
            return redirect()->route('admin.categories.index')->with('error', 'Có lỗi xảy ra khi xóa danh mục');
        }
    }
}
