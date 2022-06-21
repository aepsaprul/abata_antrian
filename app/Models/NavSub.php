<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavSub extends Model
{
    use HasFactory;

    public function navMain() {
        return $this->belongsTo(NavMain::class, 'main_id', 'id');
    }

    public function navButton() {
        return $this->hasMany(NavButton::class, 'sub_id', 'id');
    }
}
