<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavAccess extends Model
{
    use HasFactory;

    public function karyawan() {
        return $this->belongsTo(Karyawan::class, 'karyawan_id', 'id');
    }

    public function navButton() {
        return $this->belongsTo(NavButton::class, 'nav_button_id', 'id');
    }
}
