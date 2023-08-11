<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddOn extends Model
{
    use HasFactory;

    protected $table = 'add_ons';

    public function restaurant()
    {
        return $this->hasMany(AddOn::class);
    }

    public function detailAddOn()
    {
        return $this->hasMany(AddOnDetail::class);
    }
}
