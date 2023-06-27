<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantPivot extends Model
{
    use HasFactory;

    protected $table = 'restaurant_pivots';

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function addOn()
    {
        return $this->belongsTo(AddOn::class);
    }
}
