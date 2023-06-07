<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index() {
        $global_url = 'http://management-vmond.test/api/v1/vmond/tokoonline/';
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

        return view('homepage.index', compact(['response_data','response_data_biliard','response_data_meeting_room','response_data_banner']));
    }
}
