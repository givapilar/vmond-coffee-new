<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $table = 'restaurants';
    protected $fillable = [
        'name',
        'category',
        'harga',
        'status',
        'image',
        'description',
        'slug',
        'code',
        'harga_diskon',
        'stok_perhari',
        'current_stok',
        'persentase',
    ];

    public function restaurantTag()
    {
        return $this->hasMany(RestaurantPivot::class);
    }
    
    public function order()
    {
        return $this->hasMany(OrderPivot::class);
    }

    public function addOns()
    {
        return $this->hasMany(RestaurantAddOn::class, 'restaurant_id');
    }
}

