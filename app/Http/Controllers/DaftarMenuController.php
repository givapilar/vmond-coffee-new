<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DaftarMenuController extends Controller
{
    public function restaurant()
    {
        $global_url = 'http://management-vmond.test/api/v1/vmond/tokoonline/';
        $rest_api_url = $global_url .'resto';

        try {
            $json_data = file_get_contents($rest_api_url);
            // Decodes the JSON data into a PHP array.
            $restaurant = json_decode($json_data);
        } catch (\Throwable $th) {
            $restaurant = [];
        }

        return view('daftarmenu.restaurant', compact(['restaurant']));
    }
}
