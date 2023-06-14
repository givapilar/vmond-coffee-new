<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuPackages extends Model
{
    use HasFactory;

    protected $fillable = ['menu_packages_id', 'restaurant_id'];

    public function order()
    {
        return $this->hasMany(OrderPivot::class);
    }
}
