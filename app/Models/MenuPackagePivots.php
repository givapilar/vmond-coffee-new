<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuPackagePivots extends Model
{
    use HasFactory;

    protected $table = 'menu_package_pivots';

    public function biliard()
    {
        return $this->belongsTo(Biliard::class, 'billiard_id', 'id');
    }

    public function roomMeet()
    {
        return $this->belongsTo(MeetingRoom::class, 'room_meeting_id', 'id');
    }

    public function MenuPackagePivots()
    {
        return $this->hasMany(MenuPackagePivots::class);
    }

}
