<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DateInterval;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Http;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Str;

class PaymentBriController extends Controller
{
    
    public function qrDynamic(Request $request){
    
        return response()->json([
            'status' => 'success',
            'message' => 'Data retrieved successfully',
            'data' => $request->all(),
        ]);
        
    }

    public function qrMpm(Request $request){
        return response()->json([
            'status' => 'success',
            'message' => 'Data retrieved successfully',
            'data' => $request->all(),
        ]);
    }
    public function createTokenDsp(){
        $data = [
            'grant_type' => 'client_credentials',
            'client_id' => 'cb83e792-97c2-4beb-a06d-a5d1ddccb5ad',
            'client_secret' => 'a1dd3856-44b4-4ae8-a973-809bde42fb9a',
        ];
        
        $response = Http::asForm()->post('https://developer-sit.dspratama.co.id:9089/api/oauth/token', $data);
        
        // dd($response->json());
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

        // $accessToken = $request->input('access_token'); // Pastikan ini sudah diatur dari respons OAuth2 yang sebelumnya.

        $id = Str::uuid();
        $exchangeId = Str::uuid();
        $timestamp = date('Y-m-d\TH:i:s', time());
        // dd($rime);
        // Misalnya, jika Anda ingin membuat format ciphered transaction data
        $transactionDate = "00" . date("MMdd");
        $unpredictableNumber = date("ddHHmmss");
        $merchantId = "998223061218512";

        $cipheredData = $transactionDate . $unpredictableNumber . $merchantId;

        dd($cipheredData);
        $timezone = new DateTimeZone('Asia/Jakarta');

        // Buat objek DateTime untuk waktu saat ini
        $currentTime = new DateTime('now', $timezone);
        $expiryDuration = new DateInterval('PT30M'); // PT30M artinya 30 menit
        $expiryTime = $currentTime->add($expiryDuration);
        $expiryTimeFormatted = $expiryTime->format('Y-m-d\TH:i:s');

        // Data yang akan dikirim sebagai request body
        $requestData = [
            'requestInfo' => [
                'id' => $id->toString(),
                'recipient' => 'DEP',
                'sender' => 'VMONDCoffeeandEaterySpace',
                'ts' => $timestamp,
                'exchangeId' => $exchangeId,
                'tokenId' => 'ed025700-6432-11ee-a359-f57cb7269f63',
                'tokenRequestorId' => '55124444282',
                'tokenHolderId' => '99793935468',
                'amount' => 100.00, 
                'terminalId' => '10049694', 
                'expiryTime' => $expiryTimeFormatted, // Ganti dengan waktu kadaluarsa yang sesuai
                'cipheredTransactionData' => $cipheredData, // Ganti dengan data yang dienkripsi menggunakan JWE
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

    public function fetchQRCryptogram(Request $request)
    {
        // Mendapatkan access token dari OAuth2 response
        
    }

    public function createToken(Request $request){
        
        $client = new Client();
        $url = 'https://sandbox.partner.api.bri.co.id/snap/v1.0/access-token/b2b';

        $requestData = [
            'grantType' => 'client_credentials',
        ];
        
        // $currentDatetime = new DateTime('now', new DateTimeZone('UTC')); // Create a DateTime object for the current UTC time
        // $microseconds = substr((string) $currentDatetime->format('u'), 0, 3); // Extract the first three digits for milliseconds
        // $timestamp = $currentDatetime->format('Y-m-d\TH:i:s') . '.' . $microseconds . 'Z';

        $timestamp = new DateTime();
        $timestamp->setTimezone(new DateTimeZone('Asia/Jakarta'));
        $timestamp = $timestamp->format('Y-m-d\TH:i:sP');

        $dataToSign = '1DhFVj7GA8bfll4tLJuD3KzHxPO3tzCb|' . $timestamp;


        // Mendapatkan kunci privat dari file (atau sumber lainnya) dengan password
        $privateKeyPath = realpath(public_path('assetku/dataku/public-key/private-key.pem'));
        // $privateKeyPath = realpath(public_path('assetku/dataku/public-key/public-key-bri.pem'));

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

        dd($signatureBase64);

        // --------------------public key -------------------------------------------
        // $dataToSign = $client_ID . "|" . $timestamp;

        // Ubah ini ke jalur kunci publik Anda
        $clientID = "e4aad8a2762000bc06fe29ec74fa2692";
        $timeStamp = "2023-06-13T16:04:17+07:00";
        $publicKey = "-----BEGIN PUBLIC KEY-----\nMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAvSDY2+DWghiw8cLpKN7T6pos3KSZFfyJNt0SXoCcNdmwW/n8t0YjNJuW0OEcXgs5mWqT0IVd8IjGQn+a5AnFNannZ8gtWB9InVxDQHclvYQmJ9KS419ej/1TULJLy0l6EhEVVNvuIs30gvpY5MvN7z3hmllxuLM6Tn7sx8XBhIF5MkbG4JVs8OzTDKWT5N1y9AB6KEulEqxQjLh6YAVn5ZAjg5Vh7LKjlfhwPi+67UwqEK5kbqP3Vj5NdnFd+vrGvbAf46CUM1XC4i+CuEnKfrG2hWk0MQHkarBdPJI+LBJOSmJk+NqAYMvuG1/zv/3MW48/oX0/kndRzV+tvW0/pQIDAQAB\n-----END PUBLIC KEY-----";
        $signature = "FmdvyEAcJLlaBsxh0EIgNn0N0025ySKQUWNc1TjZrorB4aWdZ1VUsmOK2t7SGtJ+r0/LZr592vGx7iISy5EMEFOU7oGJDJ4iq9r9Xpg7e/sQBycAiz5WakDCEfupGWW7KKsSc8HFHy+z5JSiiMRBFB0EWuult21lU/pbBrCJIM4ThlZvl3slX1h7Ju0jnLXlxcu0xuOr/g/mkQqbgZptIG9EmIOkuiWrUm6vIU/prFBqFFGTGli/71uQ+hjD7R/Jlzvz1qdZf9XE+Ju/U4eDqrHebBQFI7lSLITVYqihLo5InQ+QgtrbcPL5UKQXXHVt0w6SVZ0CMPwN4PIL2KdYQQ==";  // BRI Always base64
        $data = $clientID . "|" . $timeStamp;  // Assuming $clientID and $timeStamp are defined

        // Load the public key
        $pubKey = openssl_get_publickey($publicKey);
        
        // Verify the signature
        $result = openssl_verify($data, base64_decode($signature), $publicKey, OPENSSL_ALGO_SHA256);

        $signatureBase64 = base64_encode($signature);

        dd($result);

        //validasi
        if ($result === 1) {
            echo 'Signature is valid.';
        } elseif ($result === 0) {
            echo 'Signature is invalid.';
        } else {
            echo 'Error verifying signature: ' . openssl_error_string();
        }


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
        dd('masuk');
        $responseData = json_decode($response->getBody(), true);
        $token = $responseData['accessToken'];


        // ------------------------------------------------------------------- Generate QR------------------------------------------------------------------------------------------------

        $requestDataQr = [
            'partnerReferenceNo' => '44443332318',
            'amount' => [
                'value' => '123456.00',
                'currency' => 'IDR',
            ],
            'merchantId' => '000001019000014',
            'terminalId' => '10049694',
        ];

        // Mengatur zona waktu ke UTC
        date_default_timezone_set('UTC');

        // Mendapatkan waktu saat ini dalam format ISO8601
        $iso8601Time = gmdate('Y-m-d\TH:i:s\.\0\00\Z', time());

        $timestamp = new DateTime();
        $timestamp->setTimezone(new DateTimeZone('Asia/Jakarta'));
        $timestampQr = $timestamp->format('Y-m-d\TH:i:sP');
        // dd($timestampQr);

        $method = 'POST'; 
        $endpointUrl = '/v1.0/qr-dynamic-mpm/qr-mpm-generate-qr'; 
        $accessToken = 'Bearer ' . $token; 
        // $accessToken = $token; // Replace with your access token
        $requestBodyQr = json_encode($requestDataQr);
        $minifiedRequestBody = strtolower(preg_replace('/\s+/', '', hash('sha256', $requestBodyQr)));
        
        
        $stringToSign = $method.':'.$endpointUrl .':'.$token . ':'.$minifiedRequestBody .':'.'2023-10-16T23:29:36+07:00';

        // Mendapatkan kunci privat dari file (atau sumber lainnya) dengan password
        // $privateKeyPath = realpath(public_path('assetku/dataku/public-key/private-key.pem'));
        $privateKeyPath = realpath(public_path('assetku/dataku/public-key/public-key-bri.pem'));
        $clientSecret = file_get_contents($privateKeyPath);

        // Generate the HMAC-SHA512 signature using the client secret
        $hmac = hash_hmac("sha512", $clientSecret, $stringToSign);
        
        // Convert the hexadecimal HMAC to base64
        $signatureBase64 = base64_encode($hmac);

        // Testing Signature
        $hash = hash('sha256', $requestBodyQr);

        $payload = $method . ":" . $endpointUrl . ":" . $token . ":". $hash . ":" . $timestampQr;

        $clientId = 'FaKm5s4fnTI35jyV';
        $hmacSignature = hash_hmac('sha512', $payload, $clientId);


        $headersQr = [
            'Authorization' => 'Bearer '.$token,
            'X-TIMESTAMP' => $timestampQr,
            'X-SIGNATURE' => $hmacSignature,
            'Content-Type' => 'application/json',
            'X-PARTNER-ID' => '456044',
            'CHANNEL-ID' => '95221',
            'X-EXTERNAL-ID' => '1223334449', // Replace with your external ID
        ];


        // Make the POST request
        $responseQr = Http::withHeaders($headersQr)
            ->post('https://sandbox.partner.api.bri.co.id/v1.0/qr-dynamic-mpm/qr-mpm-generate-qr', $requestDataQr);

            dd($responseQr->json());

        return $responseData;
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
        
        $stringToSign = "$method:$endpointUrl:$accessToken:$minifiedRequestBody:$timestamp";

        // Mendapatkan kunci privat dari file (atau sumber lainnya) dengan password
        $privateKeyPath = realpath(public_path('assetku/dataku/public-key/private-key.pem'));
        $clientSecret = file_get_contents($privateKeyPath);

        $sha256 = hash("sha256", $requestBody);

        // Create the string to sign
        $stringToSign = "$method:$endpointUrl:$accessToken:$sha256:$timestamp";

        // Generate the HMAC-SHA512 signature using the client secret
        $hmac = hash_hmac("sha512", $stringToSign, $clientSecret);
        
        // Convert the hexadecimal HMAC to base64
        $signatureBase64 = base64_encode(hex2bin($hmac));
            
        $headers = [
            'Authorization' => 'Bearer BJO07zDVvjMoAiJInJtTfOi0FBtT',
            'X-TIMESTAMP' => $timestamp,
            'X-SIGNATURE' => $signatureBase64,
            'Content-Type' => 'application/json',
            'X-PARTNER-ID' => '456044',
            'CHANNEL-ID' => '95221',
            'X-EXTRENAL-ID' => '1234567890', // Replace with your external ID
        ];


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


    public function briExample(){
        $timestamp = new DateTime();
        $timestamp->setTimezone(new DateTimeZone('Asia/Jakarta'));
        $formattedTimestamp = $timestamp->format('Y-m-d\TH:i:s.000P');// outputs: 2021-11-02T13:14:15.000+07:00
        //$formattedTimestamp = $timestamp->format('c');// outputs: 2021-11-02T13:14:15+07:00

        //format timestamp trial 1


        $granttype = "client_credentials";
        //body
        $dataToken = array(
        'grantType'=> $granttype
        );
        //buat masuk ke body
        $bodyToken = json_encode($dataToken,true);
        //json encode buat json body nya


        //private key prepare
        $fp = fopen("privatekey.pem", "r");
        $privKey = fread($fp, 8192);
        fclose($fp);
        $pKeyId = openssl_get_privatekey($privKey, 'optional_passphrase');

        $clientId = "SKj0ct6A5oKXnILeDqU7A2WIntWeQ1Ah";
        $clientSecret = "nXg2y195guLt35X5";
        $signatureToken = generateSignatureToken($pKeyId, $clientId, $formattedTimestamp);

        $requestHeadersToken = array(
                            
                            "X-TIMESTAMP:" . $formattedTimestamp,
                            "X-CLIENT-KEY:" . $clientId,
                            "X-SIGNATURE:" . $signatureToken,
                            "Content-Type:application/json",
                        );

        $urlPost ="https://sandbox.partner.api.bri.co.id/snap/v1.0/access-token/b2b";
        $chPost = curl_init();
        curl_setopt($chPost, CURLOPT_URL,$urlPost);
        curl_setopt($chPost, CURLOPT_HTTPHEADER, $requestHeadersToken);
        curl_setopt($chPost, CURLOPT_POSTFIELDS, $bodyToken);
        curl_setopt($chPost, CURLINFO_HEADER_OUT, true);
        curl_setopt($chPost, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chPost, CURLOPT_CUSTOMREQUEST, "POST");
        $resultPost = curl_exec($chPost);
        $httpCodePost = curl_getinfo($chPost, CURLINFO_HTTP_CODE);
        curl_close($chPost);


        $jsonPost = json_decode($resultPost, true);
        echo "Timestamp: " .$formattedTimestamp;
        echo "<br/> <br/>";
        echo "Response Token: ".$resultPost;
        echo "<br/> <br/>";
        $accesstoken = $jsonPost['accessToken'];
        echo "<br/> <br/>";

        /* Intrabank Request account validation  
                        Start
        */
        //body Request intrabank acc validation
        $dataRequest = array(
        'beneficiaryAccountNo'=> "888801000157508"
        );

        $bodyRequest = json_encode($dataRequest,true);
        //$bodyRequest = json_encode(json_decode($dataRequest));


        //Header request acc validation
        //Generate number random
        $panjangRandom = 15;
        $randomNumber = generateRandomNumber($panjangRandom);
        //Signature request
        $path = "/intrabank/snap/v1.0/account-inquiry-internal";
        $method = "POST";
        $token = $accesstoken;
        $signatureRequest = generateSignatureRequest($clientSecret, $method, $formattedTimestamp, $accesstoken, $bodyRequest, $path);
        $requestHeadersRequest = array(
                            
        "X-TIMESTAMP:" . $formattedTimestamp,
        "X-CLIENT-KEY:" . $clientId,
        "X-SIGNATURE:" . $signatureRequest,
        "Content-Type:application/json",
        "X-PARTNER-ID: Markicob",
        "CHANNEL-ID: BRIAP",
        "X-EXTERNAL-ID:" . $randomNumber,
        "Authorization: Bearer ".$accesstoken,
        );

        //CURL Request Fitur
        $urlPostrequest ="https://sandbox.partner.api.bri.co.id/intrabank/snap/v1.0/account-inquiry-internal";
        $chPost1 = curl_init();
        curl_setopt($chPost1, CURLOPT_URL,$urlPostrequest);
        curl_setopt($chPost1, CURLOPT_HTTPHEADER, $requestHeadersRequest);
        curl_setopt($chPost1, CURLOPT_POSTFIELDS, $bodyRequest);
        curl_setopt($chPost1, CURLINFO_HEADER_OUT, true);
        curl_setopt($chPost1, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chPost1, CURLOPT_CUSTOMREQUEST, "POST");
        $resultPostRequest = curl_exec($chPost1);
        $httpCodePostreq = curl_getinfo($chPost1, CURLINFO_HTTP_CODE);
        curl_close($chPost1);

        //echo echoan
        echo "<br\>body".$bodyRequest;
        echo "<br\><br>signature: ".$signatureRequest;
        echo "<br><br> Result: ". $resultPostRequest;


        //testing

        //generate signature Token
            function generateSignatureToken($pKeyId, $clientId, $formattedTimestamp) {
                $stringToSign = $clientId . "|" . $formattedTimestamp;
                openssl_sign($stringToSign, $signature, $pKeyId, OPENSSL_ALGO_SHA256);
                $signature = base64_encode($signature);
                return $signature;
            }

        function generateRandomNumber($panjangRandom){
            $min = pow(10, $panjangRandom - 1);
            $max = pow(10, $panjangRandom) - 1;
            return rand($min, $max);
        }

        $dataRequest = array('beneficiaryAccountNo'=> "888801000157508");
        $bodyRequest = json_encode($dataRequest,true);
        $path = "/intrabank/snap/v1.0/account-inquiry-internal";
        $method = "POST";
        $clientSecret = "nXg2y195guLt35X5";
        $accesstoken = $jsonPost['accessToken'];
        $formattedTimestamp = $timestamp;
        
        function generateSignatureRequest($clientSecret, $method, $formattedTimestamp, $accesstoken, $bodyRequest, $path){
            $sha256 = hash("sha256", $bodyRequest);
            //string to sign
            $stringToSign = "$method:$path:$accesstoken:$sha256:$formattedTimestamp";
            echo "data apa ini: ".$stringToSign . "<br><br>";

            // HMAC-SHA512 of stringToSign using client secret
            return $hmac = hash_hmac("sha512", $stringToSign, $clientSecret);
        }
    }
}
