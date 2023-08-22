<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\OrderPivot;
use App\Models\OtherSetting;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Carbon;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Cache;

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
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');

        // $this->app['request']->server->set('HTTPS', true);
        // URL::forceScheme('https');
        
        view()->composer('*', function (){
            if (Auth::user()) {
                $today = Carbon::today();
                if (Auth::user()->telephone == '081818181847') {
                    $orderTable = Order::orderBy('id', 'desc')
                        ->whereDate('created_at', $today)
                        ->where('user_id', Auth::user()->id)
                        ->where('status_pembayaran', 'Paid')
                        ->get();
                }else{
                    $orderTable = Order::orderBy('id','desc')->where('user_id', Auth::user()->id)->where('status_pembayaran', 'Paid')->get();
                }
                
            }else{
                $orderTable = [];
            }
            if (Auth::check()) {
                $restaurantMenu = Restaurant::get();
                $otherSetting = OtherSetting::get();
                

                View::share('restaurantMenu',$restaurantMenu);
                View::share('order_table',$orderTable);
                View::share('otherSetting',$otherSetting);
            }else{
                $restaurantMenu = Restaurant::get();
                $otherSetting = OtherSetting::get();
                $kodeMeja = request()->query('kode_meja');
                $getKodeMeja = Cache::put('kode_meja', $kodeMeja, now()->addSeconds(3600));
                dd($getKodeMeja);
                // dd($kodeMeja);
                View::share('order_table',$orderTable);
                View::share('restaurantMenu',$restaurantMenu);
                View::share('otherSetting',$otherSetting);
                View::share('kodeMeja',$getKodeMeja);
            }
            
        });

    }
    
}
