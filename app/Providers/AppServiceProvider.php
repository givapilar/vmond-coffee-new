<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\OrderPivot;
use App\Models\OtherSetting;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\UserManagement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Carbon;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
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

        $this->app['request']->server->set('HTTPS', true);
        URL::forceScheme('https');
        view()->composer('*', function (){
            if (Auth::user()) {
                $today = Carbon::tomorrow();
                $query = Order::query();

                if (Auth::user()->telephone == '081818181847') {
                    $oneHourAgo = Carbon::now()->subHour();
                    $query->where('created_at', '>=', $oneHourAgo);
            
                    $query->where('status_pembayaran', 'Paid')->where('user_id', Auth::user()->id);
                    $query->orderBy('id','desc');
                    $query->limit(10);
            
                    $orderTable = $query->get();
                }else{
                    $orderTable = Order::orderBy('id','desc')->where('user_id', Auth::user()->id)->where('status_pembayaran', 'Paid')->get();
                }
            }else{
                $orderTable = [];
            }
            if (Auth::check()) {
                $restaurantMenu = Restaurant::get();
                $otherSetting = OtherSetting::get();
                $kodeMeja = User::where('id', Auth::user()->id)->get()->pluck('kode_meja')->first();
                
                View::share('kodeMeja', $kodeMeja);
                View::share('restaurantMenu',$restaurantMenu);
                View::share('order_table',$orderTable);
                View::share('otherSetting',$otherSetting);
            }else{
                $restaurantMenu = Restaurant::get();
                $otherSetting = OtherSetting::get();
                $ipAddress = request()->ip();

                if (request()->query('kode_meja')) {
                    $kodeMeja = request()->query('kode_meja');
                }else{
                    $kodeMeja = null;
                }
                if ($kodeMeja != null) {
                     $cacheKey = 'kode_meja_' . $ipAddress; // Membuat kunci cache unik berdasarkan alamat IP
                    Cache::put($cacheKey, $kodeMeja, now()->addSeconds(3600));
                }
                $cacheKey = 'kode_meja_' . $ipAddress; // Kembali membuat kunci yang sesuai untuk mengambil nilai dari cache
                $getKodeMeja = Cache::get($cacheKey);

                // if (request()->query('meja')) {
                //     $Meja = request()->query('meja');
                // }else{
                //     $Meja = null;
                // }
                // if ($Meja != null) {
                //      $cacheKey = 'meja_' . $ipAddress; // Membuat kunci cache unik berdasarkan alamat IP
                //     Cache::put($cacheKey, $Meja, now()->addSeconds(3600));
                // }
                // $cacheKey = 'meja_' . $ipAddress; // Kembali membuat kunci yang sesuai untuk mengambil nilai dari cache
                // $getMeja = Cache::get($cacheKey);

                // dd($getKodeMeja);
                // dd($getKodeMeja);
                // dd($kodeMeja);
                View::share('order_table', $orderTable);
                View::share('restaurantMenu', $restaurantMenu);
                View::share('otherSetting', $otherSetting);
                View::share('kodeMeja', $getKodeMeja);
                // View::share('meja', $getMeja);

            }
        });

    }
}
