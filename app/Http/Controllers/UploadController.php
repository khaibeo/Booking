<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function handle(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time().'_'.$file->getClientOriginalName();

            $path = $file->storeAs('images', $filename, 'public');

            $image = new Image;
            $image->path = $path;
            $image->save();

            // Trả về id của hình ảnh đã lưu
            return response()->json(['image_id' => $image->id, 'path' => $image->path]);
        }

        return response()->json(['error' => 'Đã có lỗi xảy ra'], 400);
    }
}
