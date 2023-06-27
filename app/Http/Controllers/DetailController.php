<?php

namespace App\Http\Controllers;

use App\Models\AddOn;
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
}
