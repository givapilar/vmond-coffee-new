<?php

namespace App\Http\Controllers;

use App\Models\MenuPackages;
use App\Models\OtherSetting;
use App\Models\Restaurant;
use App\Models\RestaurantPivot;
use App\Models\Tag;
use Illuminate\Http\Request;

class DaftarMenuController extends Controller
{
    public function restaurant()
    {
        // $global_url = 'http://management-vmond.test/api/v1/vmond/tokoonline/';
        $global_url_image = 'http://management-vmond.test/assets/images/restaurant/';
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

        // dd($restaurant);
        return view('daftarmenu.restaurant', compact(['restaurants','tags','restaurantPivot', 'global_url_image']));
    }

    public function biliard()
    {
        $global_url = 'http://management-vmond.test/api/v1/vmond/tokoonline/';
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
        $global_url = 'http://management-vmond.test/api/v1/vmond/tokoonline/';
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
