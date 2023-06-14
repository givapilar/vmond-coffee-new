<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $table = 'restaurants';

    public function restaurantTag()
    {
        return $this->hasMany(RestaurantPivot::class);
    }
    
    public function order()
    {
        return $this->hasMany(OrderPivot::class);
    }
}

