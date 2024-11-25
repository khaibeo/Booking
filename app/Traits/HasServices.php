<?php

namespace App\Traits;

use App\Models\Service;

trait HasServices
{
    // Định nghĩa quan hệ one-to-many với model Service
    public function services()
    {
        return $this->hasMany(Service::class, 'category_id');
    }

    // Thiết lập soft delete cho các dịch vụ khi xóa danh mục
    protected static function bootHasServices()
    {
        static::deleting(function ($category) {
            $category->services()->delete(); // Xóa mềm tất cả dịch vụ thuộc về danh mục
        });
    }
}
