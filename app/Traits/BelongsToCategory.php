<?php

namespace App\Traits;

use App\Models\ServiceCategory;

trait BelongsToCategory
{
    // Định nghĩa quan hệ belongsTo với model Category
    public function category()
    {
        return $this->belongsTo(ServiceCategory::class);
    }
}
