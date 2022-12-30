<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class KonsepTimer extends Model
{
  use HasFactory;

  public function getCreatedAtAttribute() {
    return Carbon::parse($this->attributes['created_at'])->translatedFormat('d-m-Y');
  }
}
