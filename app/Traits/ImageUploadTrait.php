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
    public function uploadFile(UploadedFile $file, string $directory = 'images')
    {
        $fileName = time().'_'.$file->getClientOriginalName();

        $path = $file->storeAs($directory, $fileName, 'public');

        return [
            'name' => $fileName,
            'path' => $path,
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
        ];
    }

    /**
     * Xử lý ảnh (xóa ảnh cũ và lưu ảnh mới nếu có).
     */
    public function handleImage(?UploadedFile $newImage, ?string $currentImage, string $directory)
    {
        // Nếu có ảnh mới
        if ($newImage) {
            // Nếu có ảnh cũ, kiểm tra và xóa ảnh cũ

            if ($currentImage && Storage::disk('public')->exists($currentImage)) {
                Storage::disk('public')->delete($currentImage);
            }

            // Lưu ảnh mới
            return $this->uploadFile($newImage, $directory);
        }

        // Nếu không có ảnh mới, giữ lại ảnh cũ
        return $currentImage;
    }
}
