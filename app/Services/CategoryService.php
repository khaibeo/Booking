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

    public function updateCategory($category, array $data)
    {
        return $category->update($data);
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

    public function checkService($category)
    {
        if ($category->services()->exists()) {
            return true;
        }

        return false;
    }

    public function deleteCategory($category)
    {
        try {
            DB::beginTransaction();
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
