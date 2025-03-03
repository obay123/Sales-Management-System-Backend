<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salesmen extends Model
{
    protected $fillable = ['code', 'name', 'phone', 'address', 'is_inactive','user_id'];
    protected $table = 'salesmens';
    protected $primaryKey = 'code';
    public    $incrementing = false;

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
