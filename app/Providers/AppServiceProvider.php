<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Vehicle;


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
        View::composer(['dashboard', 'home.*'], function ($view) {
            
            $user = \Auth::user();
            $userVehicles = \DB::table('vehicles')
                            ->where('user_id', '=', $user->id)
                            ->orderBy('make', 'desc')
                            ->get();
            
            if(session('vehicle') == null || session('vehicle') == '') {
                session(['vehicle' => $user->setting->vehicle->id]);
            }

            $vehicle = \App\Vehicle::find(session('vehicle'));

            $view->with([
                'user' => $user,
                'vehicle' => $vehicle,
                'userVehicles' => $userVehicles
            ]);
        });
    }
}
