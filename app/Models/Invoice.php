<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'invoice_number',
        'address',
        'postal_code',
    ];

    public function cart(){
        return $this->hasMany(InvoiceItem::class,);
    }
}
