<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded=['id'];
    protected $table = 'customers';
    protected $primaryKey = 'id';

    protected $casts = [
        'tags' => 'array', 
        'subscription_date' => 'date', 
    ];

    public function salesmen()
    {
        return $this->belongsTo(Salesmen::class);
    }
    
    
}
