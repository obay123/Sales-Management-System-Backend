<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable=['code','name','description','user_id'];
    protected $table = 'items';
    protected $primaryKey = 'code';
    public $incrementing = false;

    public function invoices()
    {
        return $this->belongsToMany(Invoice::class, 'invoice_item')
                    ->withPivot('quantity', 'unit_price', 'line_total');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    } 
}
    