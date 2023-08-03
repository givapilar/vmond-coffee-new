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

    public function orderBilliard()
    {
        return $this->hasMany(OrderBilliard::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tableRestaurant()
    {
        return $this->belongsTo(MejaRestaurant::class, 'meja_restaurant_id');
    }
    public function tableBilliard()
    {
        return $this->belongsTo(Biliard::class, 'biliard_id');
    }
    public function tableMeetingRoom()
    {
        return $this->belongsTo(MeetingRoom::class, 'meeting_room_id');
    }
}
