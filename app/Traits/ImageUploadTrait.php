<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait ImageUploadTrait
{
    /**
     * Upload a file to a specified directory.
     *
     * @return string|null
     */
    public function uploadFile(UploadedFile $file, string $directory = 'image_app')
    {
        // Tạo tên file duy nhất
        $fileName = time().'_'.$file->getClientOriginalName();

        // Lưu ảnh vào thư mục được chỉ định hoặc thư mục mặc định
        return $file->storeAs($directory, $fileName, 'public');
    }

    /**
     * Xử lý ảnh (xóa ảnh cũ và lưu ảnh mới nếu có).
     */
    public function handleImage(?UploadedFile $newImage, ?string $currentImage, string $directory): ?string
    {
        // Nếu có ảnh mới
        if ($newImage) {
            // Nếu có ảnh cũ, kiểm tra và xóa ảnh cũ

            if ($currentImage && Storage::exists('public/'.$currentImage)) {
                Storage::delete('public/'.$currentImage);
            }

            // Lưu ảnh mới
            return $this->uploadFile($newImage, $directory);
        }

        // Nếu không có ảnh mới, giữ lại ảnh cũ
        return $currentImage;
    }
}
