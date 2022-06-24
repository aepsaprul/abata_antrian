<?php

namespace App\Providers;

use App\Models\NavAccess;
use App\Models\NavButton;
use App\Models\NavMain;
use App\Models\NavSub;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view)
        {
            if (Auth::check()) {

                $current_nav_button = NavButton::whereHas('navAccess', function ($query) {
                    $query->where('karyawan_id', Auth::user()->master_karyawan_id);
                })
                ->select('main_id')
                ->groupBy('main_id')
                ->get();

                $current_nav_button_sub = NavButton::whereHas('navAccess', function ($query) {
                    $query->where('karyawan_id', Auth::user()->master_karyawan_id);
                })
                ->select('sub_id')
                ->groupBy('sub_id')
                ->get();

                // view
                $view->with('current_nav_button', $current_nav_button);
                $view->with('current_nav_button_sub', $current_nav_button_sub);
            }else {
                $view->with('current_nav_button', null);
                $view->with('current_nav_button_sub', null);
            }
        });
    }
}
