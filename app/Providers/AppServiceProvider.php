<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\OrderPivot;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

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
            // $orderTable = Order::where('user_id', Auth::user()->id)->where('status', 'Paid')->get();
            // $orderPivot = Order::finorFail();
            // $orderTable = Order::get();
            if (Auth::user()) {
                $orderTable = Order::where('user_id', Auth::user()->id)->get();
            }else{
                $orderTable = [];
            }
            // $data['data_carts_image'] = \Cart::session(Auth::user()->id)->getContent();

            // dd($orderPivot);
            View::share('order_table',$orderTable);
            $restaurantMenu = Restaurant::get();
            View::share('restaurantMenu',$restaurantMenu);
            // View::share($data);

        });

        // $orderTable = Order::where('user_id', (Auth::user()->id ?? 2))->get();
        // $orderTable = Order::where('user_id', 2)->where('status', 'Paid')->get();
        // $orderTable = Order::where('user_id')->where('status', 'Paid')->get();
        // $orderTable = [];
        // dd($orderTable);
    }
}
