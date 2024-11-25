<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['store_id', 'code', 'user_id', 'name', 'phone', 'total_amount', 'payment_method'];

    public function details()
    {
        return $this->hasMany(InvoiceDetail::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }
}
