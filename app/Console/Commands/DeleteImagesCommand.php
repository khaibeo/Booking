<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class DeleteImagesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Xóa ảnh không thuộc về đối tượng nào';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $images = Image::whereNull('imageable_id')->get();

        foreach ($images as $image) {
            if (Storage::disk('public')->exists($image->path)) {
                Storage::disk('public')->delete($image->path);
            }

            $image->delete();
        }

        $this->info('Xóa thành công');
    }
}
