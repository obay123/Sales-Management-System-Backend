<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'customer_id',
        'total_quantity',
        'price',
        'total_price',
        'date'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function items()
    {
        return $this->belongsToMany(Item::class, 'invoice_item')
                    ->withPivot('quantity', 'unit_price', 'line_total');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
