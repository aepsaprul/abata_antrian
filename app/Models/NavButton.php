<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavButton extends Model
{
    use HasFactory;

    public function navSub() {
        return $this->belongsTo(NavSub::class, 'sub_id', 'id');
    }
}
