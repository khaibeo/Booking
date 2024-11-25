<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    use HasFactory;

    protected $fillable = ['invoice_id', 'service_id', 'quantity', 'price'];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id')->withTrashed();
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
