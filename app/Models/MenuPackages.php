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

    public function biliard()
    {
        return $this->belongsTo(Biliard::class, 'billiard_id', 'id');
    }

    public function roomMeet()
    {
        return $this->belongsTo(MeetingRoom::class, 'room_meeting_id', 'id');
    }
}
