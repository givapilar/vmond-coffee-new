<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use DateTime;
use DateTimeZone;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Http;

class APIController extends Controller
{
    // public function checkDateSchedule(Request $request)
    // {
    //     try {
    //         $getAllPaidOrderTimeFrom = Order::where('status_pembayaran', 'Paid')->whereDate('date', $request->date)->pluck('time_from')->toArray();
    //         $getAllPaidOrderTimeTo = Order::where('status_pembayaran', 'Paid')->whereDate('date', $request->date)->pluck('time_to')->toArray();
    //         $getBiliard = Order::where('status_pembayaran', 'Paid')->whereDate('date', $request->date)->pluck('biliard_id')->toArray();
    //         $mergeArray = array_merge($getAllPaidOrderTimeFrom, $getAllPaidOrderTimeTo,$getBiliard);
    //         return response()->json([
    //             'status' => 200,
    //             'message' => 'success',
    //             'times' => $mergeArray,
    //         ]);
    //     } catch (\Throwable $th) {
    //         return response()->json([
    //             'status' => 400,
    //             'message' => $th->getMessage(),
    //         ]);
    //     }

    // }
    
    public function checkDateSchedule(Request $request)
    {
        try {
            // billiard_id
            $orders = Order::where('status_pembayaran', 'Paid')
                ->whereDate('date', $request->date)
                ->where('biliard_id', $request->billiard_id)
                ->select('time_from', 'time_to', 'biliard_id')
                ->get();

            $timeFrom = [];
            $timeTo = [];
            $billiards = [];
            foreach ($orders as $order) {
                $timeFrom[] = substr($order->time_from, 0, 5);
                $timeTo[] = substr($order->time_to, 0, 5);
                $billiards[] = strval($order->biliard_id);
            }

            return response()->json([
                'status' => 200,
                'message' => 'success',
                'timeFrom' => $timeFrom,
                'timeTo' => $timeTo,
                'billiards' => $billiards,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 400,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function checkDateScheduleMeeting(Request $request)
    {
        try {
            // Meeting_id
            $orders = Order::where('status_pembayaran', 'Paid')
                ->whereDate('date', $request->date)
                ->where('meeting_room_id', $request->meeting_room_id)
                ->select('time_from', 'time_to', 'meeting_room_id')
                ->get();

            $times = [];
            $meetings = [];
            foreach ($orders as $order) {
                $times[] = substr($order->time_from, 0, 5);
                $times[] = substr($order->time_to, 0, 5);
                $meetings[] = strval($order->meeting_room_id);
            }

            return response()->json([
                'status' => 200,
                'message' => 'success',
                'times' => $times,
                'meetings' => $meetings,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 400,
                'message' => $th->getMessage(),
            ]);
        }
    }

    // ================= Integrasi =========================
    public function getTokenFintech(Request $request){
        // Buat instance dari Guzzle Client
        $client = new Client();

        try {
            $dataToSend = [
                'msisdnDev' => $request->msisdn,
                'passwordDev' => $request->password,
            ];
    
            // Lakukan permintaan HTTP POST ke URL tertentu dengan data dalam body
            $response = $client->post('http://172.31.32.85:2222/v1/api/get-token-fintech', [
                'json' => $dataToSend, // Data yang akan dikirim dalam format JSON
            ]);
    
            // Ambil isi respons sebagai string
            $data = $response->getBody()->getContents();
    
            // Sekarang Anda dapat melakukan sesuatu dengan data yang diterima
            // Konversi respons JSON menjadi array asosiatif
            $responseData = json_decode($data, true);
    
            // Kembalikan respons JSON
            return response()->json(['data' => $responseData]);
        } catch (\Exception $e) {
            // Tangani kesalahan jika ada
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function sendOTP(Request $request){
        // Buat instance dari Guzzle Client
        $client = new Client();

        try {
            $dataToSend = [
                'dttoken' => $request->dttoken,
                'notelp' => $request->notelp,
            ];
    
            // Lakukan permintaan HTTP POST ke URL tertentu dengan data dalam body
            $response = $client->post('http://172.31.32.85:2222/v1/api/send-otp-fintech', [
                'json' => $dataToSend, // Data yang akan dikirim dalam format JSON
            ]);
    
            // Ambil isi respons sebagai string
            $data = $response->getBody()->getContents();
    
            // Sekarang Anda dapat melakukan sesuatu dengan data yang diterima
            // Konversi respons JSON menjadi array asosiatif
            $responseData = json_decode($data, true);
    
            // Kembalikan respons JSON
            return response()->json(['data' => $responseData]);
        } catch (\Exception $e) {
            // Tangani kesalahan jika ada
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function createQris(Request $request){
        // Buat instance dari Guzzle Client
        $client = new Client();

        try {
            $dataToSend = [
                'amount' => $request->amount,
                'expired' => $request->expired,
            ];
    
            // Lakukan permintaan HTTP POST ke URL tertentu dengan data dalam body
            $response = $client->post('http://172.31.32.85:2222/v1/api/create-qr', [
                'json' => $dataToSend, // Data yang akan dikirim dalam format JSON
            ]);
    
            // Ambil isi respons sebagai string
            $data = $response->getBody()->getContents();
    
            // Sekarang Anda dapat melakukan sesuatu dengan data yang diterima
            // Konversi respons JSON menjadi array asosiatif
            $responseData = json_decode($data, true);
    
            // Kembalikan respons JSON
            return response()->json(['data' => $responseData]);
        } catch (\Exception $e) {
            // Tangani kesalahan jika ada
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function aktivasi(Request $request){
        // Buat instance dari Guzzle Client
        $client = new Client();

        try {
            $dataToSend = [
                'dttoken' => $request->dttoken,
                'msisdn' => $request->msisdn,
                'pin' => $request->pin,
                'product' => $request->product,
                'dtreference' => $request->dtreference,
            ];
    
            // Lakukan permintaan HTTP POST ke URL tertentu dengan data dalam body
            $response = $client->post('http://172.31.32.85:2222/v1/api/aktivasi', [
                'json' => $dataToSend, // Data yang akan dikirim dalam format JSON
            ]);
    
            // Ambil isi respons sebagai string
            $data = $response->getBody()->getContents();
    
            // Sekarang Anda dapat melakukan sesuatu dengan data yang diterima
            // Konversi respons JSON menjadi array asosiatif
            $responseData = json_decode($data, true);
    
            // Kembalikan respons JSON
            return response()->json(['data' => $responseData]);
        } catch (\Exception $e) {
            // Tangani kesalahan jika ada
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function createQR(Request $request){
        // Buat instance dari Guzzle Client
        $client = new Client();

        try {
            $dataToSend = [
                'amount' => $request->dttoken,
                'expired' => $request->msisdn,
            ];
    
            // Lakukan permintaan HTTP POST ke URL tertentu dengan data dalam body
            $response = $client->post('http://172.31.32.85:2222/v1/api/create-qr', [
                'json' => $dataToSend, // Data yang akan dikirim dalam format JSON
            ]);
    
            // Ambil isi respons sebagai string
            $data = $response->getBody()->getContents();
    
            // Sekarang Anda dapat melakukan sesuatu dengan data yang diterima
            // Konversi respons JSON menjadi array asosiatif
            $responseData = json_decode($data, true);
    
            // Kembalikan respons JSON
            return response()->json(['data' => $responseData]);
        } catch (\Exception $e) {
            // Tangani kesalahan jika ada
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function checkPayBJB(Request $request){
        $client = new Client();

        try {

            $getOrderByID = Order::where('id', $request->order_id)->first();

            $dataToSend = [
                'qrid' => $getOrderByID->invoice_id,
            ];
    
            // Lakukan permintaan HTTP POST ke URL tertentu dengan data dalam body
            $response = $client->post('http://172.31.32.85:2222/v1/api/check-status-pay', [
                'json' => $dataToSend, // Data yang akan dikirim dalam format JSON
            ]);
    
            // Ambil isi respons sebagai string
            $data = $response->getBody()->getContents();
    
            // Sekarang Anda dapat melakukan sesuatu dengan data yang diterima
            // Konversi respons JSON menjadi array asosiatif
            $responseData = json_decode($data, true);
    
            // Kembalikan respons JSON
            return response()->json(['data' => $responseData]);
        } catch (\Exception $e) {
            // Tangani kesalahan jika ada
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // ============================== Integrasi BRI ========================================================

    public function createQrisBri(Request $request){
        // Buat instance dari Guzzle Client
        $client = new Client();

        try {
            $client = new Client();
            // $url = 'https://sandbox.partner.api.bri.co.id/snap/v1.0/access-token/b2b';
            $url = 'https://partner.api.bri.co.id/snap/v1.0/access-token/b2b';


        $requestData = [
            'grantType' => 'client_credentials',
        ];
        
        $currentDatetime = new DateTime('now', new DateTimeZone('UTC')); 
        $microseconds = substr((string) $currentDatetime->format('u'), 0, 3); 
        $timestamp = $currentDatetime->format('Y-m-d\TH:i:s') . '.' . $microseconds . 'Z';

        // $dataToSign = '1DhFVj7GA8bfll4tLJuD3KzHxPO3tzCb|' . $timestamp;
        $dataToSign = 'J1JrstpgKhhuC9Em16QOzZlLQBLjaG1F|' . $timestamp;

        // Mendapatkan kunci privat dari file (atau sumber lainnya) dengan password
        $privateKeyPath = realpath(public_path('assetku/dataku/public-key/private-key.pem'));

        // Membaca kunci privat dari file dengan passphrase
        $privateKey = openssl_pkey_get_private(file_get_contents($privateKeyPath));

        if ($privateKey === false) {
            die("Failed to load private key: " . openssl_error_string());
        }
        
        $signature = '';
        // Melakukan tanda-tangan dengan metode SHA256withRSA
        openssl_sign($dataToSign, $signature, $privateKey, OPENSSL_ALGO_SHA256);
        
        openssl_free_key($privateKey);

        // Konversi tanda-tangan ke bentuk base64
        $signatureBase64 = base64_encode($signature);
        
        $headers = [
            'X-SIGNATURE' => $signatureBase64,
            // 'X-CLIENT-KEY' => '1DhFVj7GA8bfll4tLJuD3KzHxPO3tzCb',
            'X-CLIENT-KEY' => 'J1JrstpgKhhuC9Em16QOzZlLQBLjaG1F', // Ganti dengan client key yang Anda miliki
            'X-TIMESTAMP' => $timestamp,
            'Content-Type' => 'application/json',
        ];

        
        // Membuat permintaan POST
        $response = $client->post($url, [
            RequestOptions::HEADERS => $headers,
            RequestOptions::JSON => $requestData, // Mengirim data dalam format JSON
        ]);
        
        // Mendapatkan respons dari API
        $responseData = json_decode($response->getBody(), true);

        // dd($responseData);
        $token = $responseData['accessToken'];


        // ------------------------------------------------------------------- Generate QR------------------------------------------------------------------------------------------------
        $timestamp = time(); // Dapatkan timestamp saat ini
        $randomSeed = $timestamp % 10000; // Gunakan 4 digit terakhir dari timestamp sebagai "seed" untuk angka acak
        $randomDigits = str_pad(mt_rand($randomSeed, 9999), 6, '0', STR_PAD_LEFT);

        $amount = $request->input('amount');
        $integer = floor($amount); // Menghilangkan desimal
        $formattedInt = number_format($integer, 2, '.', ''); // Mengonversi ke string dengan 2 desimal
        // dd($formattedInt);

        // return $formattedInt;
        
        $requestDataQr = [
            'partnerReferenceNo' => '444431'.$randomDigits,
            'amount' => [
                'value' => $formattedInt,
                'currency' => 'IDR',
            ],
            'merchantId' => '1999316155',
            'terminalId' => '10534929',
            // 'terminalId' => '10049694',
        ];

        date_default_timezone_set('UTC');

        $timestamp = new DateTime();
        $timestamp->setTimezone(new DateTimeZone('Asia/Jakarta'));
        $timestampQr = $timestamp-> format('Y-m-d\TH:i:sP');

        $method = 'POST'; 
        $endpointUrl = '/v1.0/qr-dynamic-mpm/qr-mpm-generate-qr'; 
        $requestBodyQr = json_encode($requestDataQr);
        $minifiedRequestBody = strtolower(preg_replace('/\s+/', '', hash('sha256', $requestBodyQr)));
        
        
        $stringToSign = $method.':'.$endpointUrl .':'.$token . ':'.$minifiedRequestBody .':'.'2023-10-16T23:29:36+07:00';

        $privateKeyPath = realpath(public_path('assetku/dataku/public-key/public-key-bri.pem'));
        $clientSecret = file_get_contents($privateKeyPath);

        $hmac = hash_hmac("sha512", $clientSecret, $stringToSign);

        $signatureBase64 = base64_encode($hmac);

        $hash = hash('sha256', $requestBodyQr);

        $payload = $method . ":" . $endpointUrl . ":" . $token . ":". $hash . ":" . $timestampQr;

        // $clientId = 'FaKm5s4fnTI35jyV';
        $clientId = 'DXGJZplRCFAYvPFK';

        $hmacSignature = hash_hmac('sha512', $payload, $clientId);

        $timestamp = time(); 
        $randomSeed = $timestamp % 10000; 
        $externalId = str_pad(mt_rand($randomSeed, 9999), 6, '0', STR_PAD_LEFT);

            $headersQr = [
                'Authorization' => 'Bearer '.$token,
                'X-TIMESTAMP' => $timestampQr,
                'X-SIGNATURE' => $hmacSignature,
                'Content-Type' => 'application/json',
                // 'X-PARTNER-ID' => '456044',
                'X-PARTNER-ID' => '456044',
                'CHANNEL-ID' => '95221',
                'X-EXTERNAL-ID' => '1223'.$externalId, // Replace with your external ID
            ];


            // Make the POST request
            $responseQr = Http::withHeaders($headersQr)
            // ->post('https://sandbox.partner.api.bri.co.id/v1.0/qr-dynamic-mpm/qr-mpm-generate-qr', $requestDataQr);
            ->post('https://partner.api.bri.co.id/v1.0/qr-dynamic-mpm/qr-mpm-generate-qr', $requestDataQr);

            // Kembalikan respons JSON
            return $responseQr->json();

            // return response()->json(['data' => $responseQr]);
        } catch (\Exception $e) {
            // Tangani kesalahan jika ada
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
