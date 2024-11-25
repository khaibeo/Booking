<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Services\CategoryService;
use App\Traits\APIResponse;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    use APIResponse;

    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        try {
            $categories = $this->categoryService->getAllCategories();

            return $this->responseSuccess(null, $categories);
        } catch (\Exception $e) {
            return $this->responseServerError('Đã có lỗi xảy ra', $e->getMessage());
        }
    }

    public function store(StoreCategoryRequest $request)
    {
        $data = $request->all();

        try {
            $category = $this->categoryService->storeCategory($data);

            return $this->responseCreated('Thêm mới thành công', $category);
        } catch (\Exception $e) {
            return $this->responseServerError('Đã có lỗi xảy ra', $e->getMessage());
        }
    }

    public function show(string $id)
    {
        try {
            $category = $this->categoryService->loadIdCategory($id);
            if (! $category) {
                return $this->responseNotFound(
                    Response::HTTP_NOT_FOUND,
                    'Không tìm thấy danh mục',
                );
            } else {
                return $this->responseSuccess(null, $category);
            }
        } catch (\Exception $e) {
            return $this->responseServerError('Đã có lỗi xảy ra', $e->getMessage());
        }
    }

    public function update(StoreCategoryRequest $request, string $id)
    {
        $data = $request->validated();

        try {
            $category = $this->categoryService->loadIdCategory($id);

            if (! $category) {
                return $this->responseNotFound(
                    Response::HTTP_NOT_FOUND,
                    'Không tìm thấy danh mục',
                );
            } else {
                $this->categoryService->update($category, $data);

                return $this->responseSuccess('Cập nhật thành công', $category);
            }
        } catch (\Exception $e) {
            return $this->responseServerError('Đã có lỗi xảy ra', $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $category = $this->categoryService->loadIdCategory($id);

            if (! $category) {
                return $this->responseNotFound(
                    Response::HTTP_NOT_FOUND,
                    'Không tìm thấy danh mục',
                );
            } else {
                $this->categoryService->delete($category);

                return $this->responseDeleted();
            }
        } catch (\Exception $e) {
            return $this->responseServerError('Đã có lỗi xảy ra', $e->getMessage());
        }
    }
}
