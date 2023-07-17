<?php

namespace App\Http\Controllers;

use App\Models\AddOn;
use App\Models\MenuPackages;
use App\Models\OtherSetting;
use App\Models\Restaurant;
use App\Models\RestaurantPivot;
use App\Models\Tag;
use Illuminate\Http\Request;

class DaftarMenuController extends Controller
{
    public function restaurant(Request $request)
    {
        // $global_url = 'https://managementvmond.controlindo.com/api/v1/vmond/tokoonline/';
        $global_url_image = 'https://managementvmond.controlindo.com/assets/images/restaurant/';
        // $rest_api_url = $global_url .'resto';

        // try {
        //     $json_data = file_get_contents($rest_api_url);
        //     // Decodes the JSON data into a PHP array.
        //     $restaurant = json_decode($json_data);
        // } catch (\Throwable $th) {
        //     $restaurant = [];
        // }

        $tags = Tag::get();
        $restaurantPivot = RestaurantPivot::get();
        $restaurants = Restaurant::get();
        $category = $request->input('category');
        if ($category == 'food') {
            $category = 'Makanan';
        }elseif($category == 'drink'){
            $category = 'Minuman';
        }else{
            $category = 'Minuman';
        }

        $data ['add_ons'] = AddOn::get();
        // $data['restaurant_add_on'] = RestaurantPivot::where("restaurant_id",$id)
        // ->pluck('add_on_id')
        // ->all();

        // dd($restaurant);
        return view('daftarmenu.restaurant',$data, compact(['restaurants','tags','restaurantPivot', 'global_url_image', 'category']));
    }

    public function biliard()
    {
        $global_url = 'https://managementvmond.controlindo.com/api/v1/vmond/tokoonline/';
        $rest_api_url = $global_url .'paket-menu';

        try {
            $json_data = file_get_contents($rest_api_url);
            // Decodes the JSON data into a PHP array.
            $billiard = json_decode($json_data);
        } catch (\Throwable $th) {
            $billiard = [];
        }

        $paket_menus = MenuPackages::get();

        return view('daftarmenu.billiard', compact(['billiard','paket_menus']));
    }

    public function meetingRoom()
    {
        $global_url = 'https://managementvmond.controlindo.com/api/v1/vmond/tokoonline/';
        $rest_api_url = $global_url .'paket-menu';

        try {
            $json_data = file_get_contents($rest_api_url);
            // Decodes the JSON data into a PHP array.
            $billiard = json_decode($json_data);
        } catch (\Throwable $th) {
            $billiard = [];
        }

        $paket_menus = MenuPackages::get();
        $others = OtherSetting::get();

        return view('daftarmenu.meeting-room', compact(['billiard','paket_menus','others']));
    }
}
