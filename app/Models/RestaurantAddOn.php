<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantAddOn extends Model
{
    use HasFactory;

    protected $table = 'restaurant_add_ons';

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function addOn()
    {
        return $this->belongsTo(AddOn::class);
    }
}
