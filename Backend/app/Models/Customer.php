<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Customer extends Model
{
    protected $guarded=['id'];
    protected $table = 'customers';
    protected $primaryKey = 'id';


    protected $casts = [
        'tags' => 'array',
        'subscription_date' => 'date',
    ];

    public function getSubscriptionDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d'); // Format as yy-mm-dd
    }


    protected $appends = ['photo_url'];
    public function getPhotoUrlAttribute()
{
    return $this->photo ? url('storage/' . $this->photo) : null;
}


    public function salesmen()
    {
        return $this->belongsTo(Salesmen::class);
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
