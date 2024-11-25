<?php

namespace App\Services;

use App\Models\ServiceCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoryService
{
    public function storeCategory(array $data)
    {
        return ServiceCategory::create($data);
    }

    public function getAllCategories()
    {
        return ServiceCategory::all();
    }

    public function loadIdCategory($id)
    {
        return ServiceCategory::query()->find($id);
    }

    public function updateCategory($id, array $data)
    {
        return $this->loadIdCategory($id)->update($data);
    }

    public function update($category, $data)
    {
        return $category->update($data);
    }

    public function delete(ServiceCategory $category)
    {
        DB::transaction(function () use ($category) {
            $category->delete();
        });
    }

    public function checkService($id)
    {
        $category = ServiceCategory::findOrFail($id);

        // Kiểm tra nếu danh mục có bất kỳ service nào liên quan
        if ($category->services()->exists()) {
            return true;
        }

        return false;
    }

    public function deleteCategory($id)
    {
        try {
            DB::beginTransaction();

            $category = ServiceCategory::findOrFail($id);
            $category->delete();
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting category: '.$e->getMessage());

            return false;
        }
    }
}
