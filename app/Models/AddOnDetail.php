<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddOnDetail extends Model
{
    use HasFactory;

    protected $table = 'add_on_details';

    public function addOn()
    {
        return $this->belongsTo(AddOn::class);
    }
}
