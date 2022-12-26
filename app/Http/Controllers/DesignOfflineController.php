<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DesignOfflineController extends Controller
{
  public function customer()
  {
    return view('pages.design_offline.cutomer.index');
  }

  public function desain()
  {
    return view('pages.design_offline.desain.index');
  }

  public function desainUpload()
  {
    return view('pages.design_offline.desain.upload');
  }
}
