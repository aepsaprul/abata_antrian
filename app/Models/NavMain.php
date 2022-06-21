<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavMain extends Model
{
    use HasFactory;

    public function navSub() {
        return $this->hasMany(NavSub::class, 'main_id', 'id');
    }

    public function navButton() {
        return $this->hasMany(navButton::class, 'main_id', 'id');
    }
}
