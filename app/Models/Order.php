<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function orderPivot()
    {
        return $this->hasMany(OrderPivot::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
