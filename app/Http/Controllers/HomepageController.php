<?php

namespace App\Http\Controllers;

use App\Models\MejaRestaurant;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomepageController extends Controller
{
    public function index() {
        $global_url = 'https://managementvmond.controlindo.com/api/v1/vmond/tokoonline/';
        $rest_api_url = $global_url .'resto';
        $rest_api_biliard = $global_url .'biliard';
        $rest_api_meeting_room = $global_url .'meetingroom';
        $rest_api_banner = $global_url .'banner';
        $rest_api_banner = $global_url .'banner-dine-in';

        // Reads the JSON file.
        try {
            $json_data = file_get_contents($rest_api_url);
            $json_data_biliard = file_get_contents($rest_api_biliard);
            $json_data_meeting_room = file_get_contents($rest_api_meeting_room);
            $json_data_banner = file_get_contents($rest_api_banner);
            $json_data_banner_dine_in = file_get_contents($rest_api_banner);
            // Decodes the JSON data into a PHP array.
            $response_data = json_decode($json_data);
            $response_data_biliard = json_decode($json_data_biliard);
            $response_data_meeting_room = json_decode($json_data_meeting_room);
            $response_data_banner = json_decode($json_data_banner);
            $response_data_banner_dine_in = json_decode($json_data_banner);
        } catch (\Throwable $th) {
            $response_data = [];
            $response_data_biliard =[];
            $response_data_meeting_room =[];
            $response_data_banner =[];
            $response_data_banner_dine_in =[];
        }

        if (Auth::check()) {
            $orderFinishSubtotal = Order::where('user_id',Auth::user()->id)->where('status_pembayaran','Paid')->sum('total_price');
            $meja_restaurants = MejaRestaurant::get();
            $banner = MejaRestaurant::get();
            $orderTableId['orderTable'] = Order::where('user_id', Auth::user()->id)->get();
            return view('homepage.index', compact(['response_data','response_data_biliard','response_data_meeting_room','response_data_banner','response_data_banner_dine_in','orderFinishSubtotal','orderTableId', 'meja_restaurants']),$orderTableId);
        }else{
            $orderFinishSubtotal = 0;
            $meja_restaurants = MejaRestaurant::get();
            $orderTableId['orderTable'] = Order::get();
            return view('homepage.index', compact(['response_data','response_data_biliard','response_data_meeting_room','response_data_banner','response_data_banner_dine_in','orderFinishSubtotal','orderTableId', 'meja_restaurants']),$orderTableId);
        }

    }

    public function dineIn(){
        return view('homepage.dine-in');
    }

    public function login(Request $request){
        // dd($request->all());
        return view('Auth.login');
    }

    public function homeMenu() {
        $global_url = 'https://managementvmond.controlindo.com/api/v1/vmond/tokoonline/';
        $rest_api_url = $global_url .'resto';
        $rest_api_biliard = $global_url .'biliard';
        $rest_api_meeting_room = $global_url .'meetingroom';
        $rest_api_banner = $global_url .'banner';

        // Reads the JSON file.
        try {
            $json_data = file_get_contents($rest_api_url);
            $json_data_biliard = file_get_contents($rest_api_biliard);
            $json_data_meeting_room = file_get_contents($rest_api_meeting_room);
            $json_data_banner = file_get_contents($rest_api_banner);
            // Decodes the JSON data into a PHP array.
            $response_data = json_decode($json_data);
            $response_data_biliard = json_decode($json_data_biliard);
            $response_data_meeting_room = json_decode($json_data_meeting_room);
            $response_data_banner = json_decode($json_data_banner);
        } catch (\Throwable $th) {
            $response_data = [];
            $response_data_biliard =[];
            $response_data_meeting_room =[];
            $response_data_banner =[];
        }

        if (Auth::check()) {
            $orderFinishSubtotal = Order::where('user_id',Auth::user()->id)->where('status_pembayaran','Paid')->sum('total_price');
            $meja_restaurants = MejaRestaurant::get();
            $banner = MejaRestaurant::get();
            $orderTableId['orderTable'] = Order::where('user_id', Auth::user()->id)->get();
            return view('homepage.home-menu', compact(['response_data','response_data_biliard','response_data_meeting_room','response_data_banner','orderFinishSubtotal','orderTableId', 'meja_restaurants']),$orderTableId);
        }else{
            $orderFinishSubtotal = 0;
            $meja_restaurants = MejaRestaurant::get();
            $orderTableId['orderTable'] = Order::get();
            return view('homepage.home-menu', compact(['response_data','response_data_biliard','response_data_meeting_room','response_data_banner','orderFinishSubtotal','orderTableId', 'meja_restaurants']),$orderTableId);
        }

    }
}
