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
            $filename = time() . '_' . $file->getClientOriginalName();

            $path = $file->storeAs('images', $filename, 'public');

            $image = new Image;
            $image->name = $filename;
            $image->path = $path;
            $image->mime_type = $file->getMimeType();
            $image->file_size = $file->getSize();

            $image->save();

            return response()->json(['image_id' => $image->id, 'path' => $image->path]);
        }

        return response()->json(['error' => 'Đã có lỗi xảy ra'], 400);
    }
}
