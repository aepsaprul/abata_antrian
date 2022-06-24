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

    public function navAccess() {
        return $this->hasMany(NavAccess::class, 'nav_button_id', 'id');
    }

    public function navMain() {
        return $this->belongsTo(NavMain::class, 'main_id', 'id');
    }
}
