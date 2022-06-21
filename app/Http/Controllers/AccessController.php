<?php

namespace App\Http\Controllers;

use App\Models\NavButton;
use App\Models\NavMain;
use App\Models\NavSub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccessController extends Controller
{
    public function index()
    {
        $nav_button = NavButton::get();
        $nav_sub = NavSub::get();
        $nav_main = NavMain::with('navButton')
            ->get();

        $button = NavButton::with('navSub')
            ->select(DB::raw('count(sub_id) as total'), DB::raw('count(main_id) as mainid'), 'sub_id')
            ->groupBy('sub_id')
            ->get();

        $total_main = NavButton::with('navSub')
            ->select(DB::raw('count(main_id) as total_main'), 'main_id')
            ->groupBy('main_id')
            ->get();

        // dd($button);

        return view('pages.access.index', [
            'nav_buttons' => $nav_button,
            'buttons' => $button,
            'total_main' => $total_main,
            'nav_subs' => $nav_sub,
            'nav_mains' => $nav_main
        ]);
    }
}
