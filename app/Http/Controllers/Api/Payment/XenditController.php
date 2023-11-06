<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Xendit\Xendit;
use Carbon\Carbon;

class XenditController extends Controller
{
    private $token = 'xnd_development_Nw3d9yOQ6EKrrxlmpYN0DOhB6tJD4nuUR6msxcpaCf7Vk978ynR5D8UJ7qr4mDge';

    public function getListVa(){

        Xendit::setApiKey($this->token);

        $getVABanks = \Xendit\VirtualAccounts::getVABanks();

        return response()->json([
            'data' => $getVABanks
        ])->setStatusCode(200);
    }

    public function createVa(Request $request){
        Xendit::setApiKey($this->token);

        $params = [
            "external_id" => \uniqid(),
            "bank_code" => $request->bank,
            "name" => $request->user_name,
            "expected_amount" => $request->price,
            "is_closed" => true,
            "expiration_date" => Carbon::now()->addDays(1)->toISOString(),
            "is_single_use" => true,
        ];

        $createVA = \Xendit\VirtualAccounts::create($params);

        return response()->json([
            'data' => $createVA
        ])->setStatusCode(200);
    }
}
