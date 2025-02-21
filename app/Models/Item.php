<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable=['code','name','description'];
    protected $table = 'items';
    protected $primaryKey = 'code';
    public $incrementing = false;
}
    