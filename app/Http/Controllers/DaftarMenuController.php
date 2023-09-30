<?php

namespace App\Http\Controllers;

use App\Models\AddOn;
use App\Models\Banner;
use App\Models\MenuPackages;
use App\Models\Order;
use App\Models\OtherSetting;
use App\Models\Restaurant;
use App\Models\RestaurantPivot;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DaftarMenuController extends Controller
{
    public function restaurant(Request $request)
    {
        $global_url_image = 'https://managementvmond.controlindo.com/assets/images/restaurant/';

        $tags = Tag::where('status', 'active')->orderBy('position', 'ASC')->get();
        $restaurantPivot = RestaurantPivot::get();
        $restaurants = Restaurant::get();
        $data['category'] = $request->input('category');
        if ($data['category'] == 'food') {
            $data['category'] = 'Makanan';
        }elseif($data['category'] == 'drink'){
            $data['category'] = 'Minuman';
        }else{
            $data['category'] = 'Minuman';
        }

        $data['menu'] = $request->input('menu');
        // dd($data['menu']);

        $data ['add_ons'] = AddOn::get();
        // dd($restaurant);
        return view('daftarmenu.restaurant',$data, compact(['restaurants','tags','restaurantPivot', 'global_url_image']));
    }

    public function biliard()
    {
        $global_url = 'https://managementvmond.controlindo.com/api/v1/vmond/tokoonline/';
        $rest_api_url = $global_url .'paket-menu';
        if (Auth::check()) {
            $orderFinishSubtotal = Order::where('user_id',Auth::user()->id)->where('status_pembayaran','Paid')->sum('total_price');
        }else{
            $orderFinishSubtotal = 0;
        }

        try {
            $json_data = file_get_contents($rest_api_url);
            // Decodes the JSON data into a PHP array.
            $billiard = json_decode($json_data);
        } catch (\Throwable $th) {
            $billiard = [];
        }

        
        $paket_menus = MenuPackages::orderBy('minimal','asc')->get();
        $data['banners'] = Banner::get();

        return view('daftarmenu.billiard', $data, compact(['billiard','paket_menus', 'orderFinishSubtotal']));
    }

    public function meetingRoom()
    {
        $global_url_image = 'https://managementvmond.controlindo.com/assets/images/paket-menu/';

        $global_url = 'https://managementvmond.controlindo.com/api/v1/vmond/tokoonline/';
        $rest_api_url = $global_url .'paket-menu';
        if (Auth::check()) {
            $orderFinishSubtotal = Order::where('user_id',Auth::user()->id)->where('status_pembayaran','Paid')->sum('total_price');
        }else{
            $orderFinishSubtotal = 0;
        }
        try {
            $json_data = file_get_contents($rest_api_url);
            // Decodes the JSON data into a PHP array.
            $meeting_room = json_decode($json_data);
        } catch (\Throwable $th) {
            $meeting_room = [];
        }

        $paket_menus = MenuPackages::get();
        $others = OtherSetting::get();
        $data['banners'] = Banner::get();

        return view('daftarmenu.meeting-room', $data, compact(['meeting_room','paket_menus','others','orderFinishSubtotal','global_url_image']));
    }

    public function paketMenu(Request $request)
    {
        $global_url_image = 'https://managementvmond.controlindo.com/assets/images/restaurant/';

        $tags = Tag::where('status', 'active')->orderBy('position', 'ASC')->get();
        $restaurantPivot = RestaurantPivot::get();
        $restaurants = Restaurant::get();
        $paket_menus = MenuPackages::get();
        $data['category'] = $request->input('category');
        if ($data['category'] == 'food') {
            $data['category'] = 'Makanan';
        }elseif($data['category'] == 'drink'){
            $data['category'] = 'Minuman';
        }else{
            $data['category'] = 'Minuman';
        }

        $data['menu'] = $request->input('menu');
        // dd($data['menu']);

        $data ['add_ons'] = AddOn::get();
        // dd($restaurant);
        return view('daftarmenu.paket-menu',$data, compact(['restaurants','tags','restaurantPivot', 'global_url_image','paket_menus']));
    }
}
