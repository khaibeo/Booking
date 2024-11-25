<?php

namespace App\Models;

use App\Traits\HasServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class ServiceCategory extends Model
{
    use HasFactory, HasServices, SoftDeletes;

    protected $table = 'service_categories';

    protected $fillable = ['name', 'description'];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($category) {
            Log::info("Deleting category: {$category->id}");
            Log::info('Associated services count: '.$category->services()->count());
        });
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'category_id');
    }
}
