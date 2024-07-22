<?php

namespace App\Http\Controllers;

use App\Models\AddOn;
use App\Models\Biliard;
use App\Models\MeetingRoom;
use App\Models\MenuPackagePivots;
use App\Models\MenuPackages;
use App\Models\Order;
use App\Models\OtherSetting;
use App\Models\Restaurant;
use App\Models\RestaurantAddOn;
use App\Models\RestaurantPivot;
use App\Models\User;
use App\Models\UserManagement;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function detailRestaurant($id, $category)
    {
        // dd();
        $data ['image'] = 'https://managementvmond.controlindo.com/assets/images/restaurant/';

        $data ['restaurants'] = Restaurant::find($id);
        $data ['restaurant_details'] = RestaurantPivot::get();
        $data ['add_ons'] = AddOn::get();
        $data['restaurant_add_on'] = RestaurantAddOn::where("restaurant_id",$id)
        ->pluck('add_on_id')
        ->all();
        $category = $category;
        $data['category'] = $category;

        $data['users'] = User::first();

        // dd($restaurant);
        return view('daftarmenu.detail-restaurant',$data);
    }

    public function detailPaket($id)
    {
        // dd();
        $data ['image'] = 'https://managementvmond.controlindo.com/assets/images/restaurant/';

        $data ['restaurants'] = Restaurant::get();
        $data ['paket_menu'] = MenuPackages::find($id);
        $data['menu_package_pivots'] = MenuPackagePivots::where('menu_packages_id', $id)
        ->pluck('restaurant_id')
        ->all();
        $data ['restaurant_details'] = RestaurantPivot::get();
        $data ['add_ons'] = AddOn::get();
        $data['users'] = User::first();

        // dd($restaurant);
        return view('daftarmenu.detail-paket-menu',$data);
    }

    public function detailBilliard($id)
    {
        // dd();
        $data ['image'] = 'https://managementvmond.controlindo.com/assets/images/paket-menu/';

        $data ['paket_menu'] = MenuPackages::find($id);
        $data ['paket_details'] = MenuPackagePivots::get();
        $data ['billiard'] = Biliard::get();
        $data ['add_ons'] = AddOn::get();
        $data['restaurant_add_on'] = RestaurantAddOn::where("restaurant_id",$id)
        ->pluck('add_on_id')
        ->all();
        // dd($data['restaurant_add_on']) ;
        $data ['restaurants'] = Restaurant::get();
        $data ['userManagement'] = UserManagement::get();
        $data ['order_settings'] = OtherSetting::get();
        $data ['orders'] = Order::get();
        $data['menu_package_pivots'] = MenuPackagePivots::where('menu_packages_id', $id)
        ->pluck('restaurant_id')
        ->all();

        $rest_api_url = 'https://managementvmond.controlindo.com/api/v1/vmond/user/get-role';

        $getData = file_get_contents($rest_api_url);
        try {
            $role = json_decode($getData);
            // dd($role);
            // $data = $data->data;
        } catch (\Throwable $th) {
            $role = [];
        }

        return view('daftarmenu.detail-billiard',$data,compact(['role']));
    }

    public function detailBilliardOpenbill()
    {
        $data ['image'] = 'https://managementvmond.controlindo.com/assets/images/paket-menu/';
        $data ['billiard'] = Biliard::get();
        return view('daftarmenu.billiard.detail-open-bill',$data);
    }

    public function detailBilliardGuest($id)
    {
        // dd();
        $data ['image'] = 'https://managementvmond.controlindo.com/assets/images/paket-menu/';

        $data ['paket_menu'] = MenuPackages::find($id);
        $data ['paket_details'] = MenuPackagePivots::get();
        $data ['billiard'] = Biliard::get();
        $data ['add_ons'] = AddOn::get();
        $data['restaurant_add_on'] = RestaurantAddOn::where("restaurant_id",$id)
        ->pluck('add_on_id')
        ->all();
        // dd($data['restaurant_add_on']) ;
        $data ['restaurants'] = Restaurant::get();
        $data ['userManagement'] = UserManagement::get();
        $data ['order_settings'] = OtherSetting::get();
        $data ['orders'] = Order::get();
        $data['menu_package_pivots'] = MenuPackagePivots::where('menu_packages_id', $id)
        ->pluck('restaurant_id')
        ->all();

        $rest_api_url = 'https://managementvmond.controlindo.com/api/v1/vmond/user/get-role';

        $getData = file_get_contents($rest_api_url);
        try {
            $role = json_decode($getData);
            // dd($role);
            // $data = $data->data;
        } catch (\Throwable $th) {
            $role = [];
        }

        return view('daftarmenu.detail-billiard-guest',$data,compact(['role']));
    }

    public function detailMeeting($id)
    {
        // dd();
        $data ['image'] = 'https://managementvmond.controlindo.com/assets/images/paket-menu/';

        $data ['paket_menu'] = MenuPackages::find($id);
        $data ['paket_details'] = MenuPackagePivots::get();
        $data ['meeting_rooms'] = MeetingRoom::get();
        $data ['restaurants'] = Restaurant::get();
        $data['menu_package_pivots'] = MenuPackagePivots::where('menu_packages_id', $id)
        ->pluck('restaurant_id')
        ->all();

        return view('daftarmenu.detail-meeting',$data);
    }


}
