<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\OrderPivot;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;


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
        view()->composer('*', function (){
            // $orderTable = Order::where('user_id', Auth::user()->id)->where('status', 'Paid')->get();
            // $orderPivot = Order::finorFail();
            $orderTable = Order::get();
            // $orderTable = OrderPivot::get();
            // dd($orderPivot);
            View::share('order_table',$orderTable);
        });

        // $orderTable = Order::where('user_id', (Auth::user()->id ?? 2))->get();
        // $orderTable = Order::where('user_id', 2)->where('status', 'Paid')->get();
        // $orderTable = Order::where('user_id')->where('status', 'Paid')->get();
        // $orderTable = [];
        // dd($orderTable);
    }
}
