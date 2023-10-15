<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Http;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Str;

class PaymentBriController extends Controller
{
    
    public function endpoint(){
        dd('masuk');
    }
    public function createTokenDsp(){
        $data = [
            'grant_type' => 'client_credentials',
            'client_id' => 'cb83e792-97c2-4beb-a06d-a5d1ddccb5ad',
            'client_secret' => 'a1dd3856-44b4-4ae8-a973-809bde42fb9a',
        ];
        
        $response = Http::asForm()->post('https://developer-sit.dspratama.co.id:9089/api/oauth/token', $data);
        
        dd($response->json());
        if ($response->successful()) {
            $tokenData = $response->json();
            $accessToken = $tokenData['access_token'];
            $tokenType = $tokenData['token_type'];
            $expiresIn = $tokenData['expires_in'];
            $scope = $tokenData['scope'];
        
            // Lakukan sesuatu dengan token, tipe token, waktu kedaluwarsa, dan scope di sini.
        } else {
            // Permintaan gagal, Anda dapat menangani kesalahan di sini.
            $errorMessage = $response->body();
            $statusCode = $response->status();
        }
    }

    public function fetchQRCryptogram(Request $request)
    {
        // Mendapatkan access token dari OAuth2 response
        $accessToken = $request->input('access_token'); // Pastikan ini sudah diatur dari respons OAuth2 yang sebelumnya.

        $id = Str::uuid();
        $exchangeId = Str::uuid();
        $timestamp = date('Y-m-d\TH:i:s', time());
        // dd($id->toString());
        // Data yang akan dikirim sebagai request body
        $requestData = [
            'requestInfo' => [
                'id' => $id->toString(),
                'recipient' => 'DEP',
                'sender' => 'VMONDCoffeeandEaterySpace',
                'ts' => $timestamp,
                'exchangeId' => $exchangeId,
                'tokenId' => 'Value given by DSP',
                'tokenRequestorId' => 'Value given by DSP',
                'tokenHolderId' => 'Value given by DSP',
                'amount' => 100.00, // Ganti dengan nilai yang sesuai
                'terminalId' => 'Terminal ID', // Ganti dengan nilai yang sesuai
                'expiryTime' => '2023-12-31T23:59:59', // Ganti dengan waktu kadaluarsa yang sesuai
                'cipheredTransactionData' => 'ENCRYPTED_DATA', // Ganti dengan data yang dienkripsi menggunakan JWE
            ]
        ];

        $response = Http::withToken($accessToken)->post('https://your-api-url.com/api/v1/remoteQR/fetchQRCryptogram', $requestData);

        if ($response->successful()) {
            // Respons berhasil, Anda dapat menangani data respons di sini
            $responseData = $response->json();
        } else {
            // Permintaan gagal, Anda dapat menangani kesalahan di sini
            $errorMessage = $response->body();
            $statusCode = $response->status();
        }
    }

    public function createToken(Request $request){
        // try {
        //     //code...
        
        $client = new Client();

        // URL untuk menghasilkan token akses di lingkungan sandbox
        $url = 'https://sandbox.partner.api.bri.co.id/snap/v1.0/access-token/b2b';

        // Data otentikasi
        $requestData = [
            'grantType' => 'client_credentials',
        ];
        
        $currentDatetime = new DateTime('now', new DateTimeZone('UTC')); // Create a DateTime object for the current UTC time
        $microseconds = substr((string) $currentDatetime->format('u'), 0, 3); // Extract the first three digits for milliseconds
        $timestamp = $currentDatetime->format('Y-m-d\TH:i:s') . '.' . $microseconds . 'Z';

        $dataToSign = '1DhFVj7GA8bfll4tLJuD3KzHxPO3tzCb|' . $timestamp;

        // Mendapatkan kunci privat dari file (atau sumber lainnya) dengan password
        $privateKeyPath = realpath(public_path('assetku/dataku/public-key/private-key.pem'));
   
        $password = 'Together1!';
        
        // Membaca kunci privat dari file dengan passphrase
        $privateKey = openssl_pkey_get_private(file_get_contents($privateKeyPath));
    
        // dd($privateKey);

        if ($privateKey === false) {
            die("Failed to load private key: " . openssl_error_string());
        }
        
        $signature = '';
        // Melakukan tanda-tangan dengan metode SHA256withRSA
        openssl_sign($dataToSign, $signature, $privateKey, OPENSSL_ALGO_SHA256);
        
        openssl_free_key($privateKey);

        // Konversi tanda-tangan ke bentuk base64
        $signatureBase64 = base64_encode($signature);
     
        // Header
        $headers = [
            'X-SIGNATURE' => $signatureBase64, // Tanda-tangan base64
            'X-CLIENT-KEY' => '1DhFVj7GA8bfll4tLJuD3KzHxPO3tzCb', // Ganti dengan client key yang Anda miliki
            'X-TIMESTAMP' => $timestamp, // Format timestamp sesuai dengan deskripsi
            'Content-Type' => 'application/json',
        ];

        
        // Membuat permintaan POST
        $response = $client->post($url, [
            RequestOptions::HEADERS => $headers,
            RequestOptions::JSON => $requestData, // Mengirim data dalam format JSON
        ]);
        
        // Mendapatkan respons dari API
        $responseData = json_decode($response->getBody(), true);
        return $responseData;
        // } catch (\Throwable $th) {
        //     return $th->getMessage();
        // }
    }

    public function generateQR(Request $request)
    {
        // Define the request data based on the provided structure
        $requestData = [
            'partnerReferenceNo' => '123456123456',
            'amount' => [
                'value' => 123456.00,
                'currency' => 'IDR',
            ],
            'merchantId' => '000001019000014',
            'terminalId' => '10049694',
        ];

        $dateTime = new DateTime();
        $timestamps = $dateTime->format('c');

        $dateTime = new DateTime($timestamps);
        $offset = $dateTime->format('P'); // Get the offset in ISO 8601 format (e.g., +07:00)
        $milliseconds = substr($dateTime->format('u'), '0',3); // Remove trailing zeros
        $timestamp = $dateTime->format('Y-m-d\TH:i:s.') . $milliseconds . $offset;
        // dd($timestamp);


        $method = 'POST'; // Replace with your HTTP method (e.g., GET, POST)
        $endpointUrl = '/v1.0/qr-dynamic-mpm/qr-mpm-generate-qr'; // Replace with your API endpoint URL
        $accessToken = 'Bearer BJO07zDVvjMoAiJInJtTfOi0FBtT'; // Replace with your access token
        $requestBody = json_encode($requestData);
        $hashedRequestBody = hash('sha256', $requestBody);
        $minifiedRequestBody = strtolower(preg_replace('/\s+/', '', $hashedRequestBody));
        // dd($minifiedRequestBody);
        
        $stringToSign = "$method:$endpointUrl:$accessToken:$minifiedRequestBody:$timestamp";

        // Mendapatkan kunci privat dari file (atau sumber lainnya) dengan password
        $privateKeyPath = realpath(public_path('assetku/dataku/public-key/private-key.pem'));
        $clientSecret = file_get_contents($privateKeyPath);

        $sha256 = hash("sha256", $requestBody);

        // Create the string to sign
        $stringToSign = "$method:$endpointUrl:$accessToken:$sha256:$timestamp";

        // dd($stringToSign);
        
        // Generate the HMAC-SHA512 signature using the client secret
        $hmac = hash_hmac("sha512", $stringToSign, $clientSecret);
        
        // Convert the hexadecimal HMAC to base64
        $signatureBase64 = base64_encode(hex2bin($hmac));

        // dd($signatureBase64);
            
        $headers = [
            'Authorization' => 'Bearer BJO07zDVvjMoAiJInJtTfOi0FBtT',
            'X-TIMESTAMP' => $timestamp,
            'X-SIGNATURE' => $signatureBase64,
            'Content-Type' => 'application/json',
            'X-PARTNER-ID' => '456044',
            'CHANNEL-ID' => '95221',
            'X-EXTRENAL-ID' => '1234567890', // Replace with your external ID
        ];

        // dd($headers);
        // dd($headers);

        // Make the POST request
        $response = Http::withHeaders($headers)
            ->post('https://sandbox.partner.api.bri.co.id/v1.0/qr-dynamic-mpm/qr-mpm-generate-qr', $requestData);

            dd($response->json());
        // Check the response status and handle it accordingly
        if ($response->successful()) {
            // Request was successful, you can process the response here
            $responseData = $response->json();
            // Do something with $responseData
        } else {
            // Request failed, handle the error
            $errorResponse = $response->json();
            // Handle the error response
        }

        return response()->json($responseData);
    }

}
