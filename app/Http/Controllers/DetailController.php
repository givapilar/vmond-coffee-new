<?php

namespace App\Http\Controllers;

use App\Models\AddOn;
use App\Models\Biliard;
use App\Models\MenuPackagePivots;
use App\Models\MenuPackages;
use App\Models\Restaurant;
use App\Models\RestaurantPivot;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function detailRestaurant($id)
    {
        // dd();
        $data ['image'] = 'https://managementvmond.controlindo.com/assets/images/restaurant/';

        $data ['restaurants'] = Restaurant::find($id);
        $data ['restaurant_details'] = RestaurantPivot::get();
        $data ['add_ons'] = AddOn::get();
        $data['restaurant_add_on'] = RestaurantPivot::where("restaurant_id",$id)
        ->pluck('add_on_id')
        ->all();
        // dd($restaurant);
        return view('daftarmenu.detail-restaurant',$data);
    }

    public function detailBilliard($id)
    {
        // dd();
        $data ['image'] = 'https://managementvmond.controlindo.com/assets/images/paket-menu/';

        $data ['paket_menu'] = MenuPackages::find($id);
        $data ['paket_details'] = MenuPackagePivots::get();
        $data ['billiard'] = Biliard::get();
        $data ['restaurants'] = Restaurant::get();
        $data['menu_package_pivots'] = MenuPackagePivots::where('menu_packages_id', $id)
        ->pluck('restaurant_id')
        ->all();
        
        return view('daftarmenu.detail-billiard',$data);
    }

    public function detailMeeting($id)
    {
        // dd();
        $data ['image'] = 'https://managementvmond.controlindo.com/assets/images/paket-menu/';

        $data ['paket_menu'] = MenuPackages::find($id);
        $data ['paket_details'] = MenuPackagePivots::get();
        $data ['billiard'] = Biliard::get();
        $data ['restaurants'] = Restaurant::get();
        $data['menu_package_pivots'] = MenuPackagePivots::where('menu_packages_id', $id)
        ->pluck('restaurant_id')
        ->all();
        
        return view('daftarmenu.detail-meeting',$data);
    }


}
