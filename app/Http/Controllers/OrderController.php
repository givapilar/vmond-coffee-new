<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\Order;
use App\Models\OrderPivot;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Xendit\Xendit;
// require 'vendor/autoload.php';
class OrderController extends Controller
{
    public function index()
    {

        return view('checkout.order');
    }

    public function checkout(Request $request)
    {
        $request->request->add(['qty' => $request->qty]);
        // dd($request->request->add(['qty' => $request->qty]));
        $biaya_layanan = 5000;
        $price = 1;
        // $session_cart = \Cart::session(Auth::user()->id)->getContent();
        $session_cart = \Cart::session(Auth::user()->id)->getContent();

        

        foreach ($session_cart as $key => $value) {
            $price +=$value->price;
        }
        $currentYear = date('YmdHis');
        $orderInvoice = Order::orderBy('id', 'desc')->first();

        if ($orderInvoice) {
            $lastInvoiceNumber = $orderInvoice->invoice_no;
            $lastInvoiceYear = substr($lastInvoiceNumber, 0, 4);

            if ($lastInvoiceYear == $currentYear) {
                $lastInvoiceIncrement = (int) substr($lastInvoiceNumber, 4);
                $newInvoiceNumber = $currentYear . str_pad($lastInvoiceIncrement + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $newInvoiceNumber = $currentYear . '1';
            }
        } else {
            $newInvoiceNumber = $currentYear . '1';
        }

        // return $newInvoiceNumber;
        
        // \Cart::session(Auth::user()->id)->add(array(
            //     'id' => $restaurant->id, // inique row ID
            //     'name' => $restaurant->nama,
            //     'price' => $restaurant->harga,
            //     'quantity' => $request->quantity,
            //     'attributes' => array($restaurant),
            //     'associatedModel' => Restaurant::class
            // ));
            
        $restaurant = Restaurant::get();
        
        // dd($request->all());
        // $member = Membership::get();
        // \Cart::session(Auth::user()->id)->add(array(
            //     'id' => $restaurant->id,
            //     'quantity' => $request->quantity,
            // ));
            
            // $session_cart = \Cart::session(Auth::user()->id)->getContent();

            if (Auth::user()->membership->level == 'Super Platinum') {
                $order = Order::create([
                    // $request->all()
                    'user_id' => auth()->user()->id,
                    'name' => auth()->user()->username,
                    'qty' => $request->qty,
                    'code' => $newInvoiceNumber,
                    'date' => $request->date,
                    'time_from' => $request->time_from,
                    'time_to' => $request->time_to,
                    // 'total_price' => \Cart::getTotal() *11/100 + \Cart::getTotal() + $biaya_layanan, 
                    // 'total_price' =>  \Cart::getTotal(), 
                    'total_price' => 0, 
                    'status_pembayaran' => 'Unpaid',
                    'invoice_no' => $newInvoiceNumber,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            } else {
                $biaya_layanan = 0;
                $order = Order::create([
                    // $request->all()
                    'user_id' => auth()->user()->id,
                    'name' => auth()->user()->username,
                    'qty' => $request->qty,
                    'code' => $newInvoiceNumber,
                    'date' => $request->date,
                    'time_from' => $request->time_from,
                    'time_to' => $request->time_to,
                    'biliard_id' => $request->biliard_id,
                    // 'total_price' => \Cart::getTotal() *11/100 + \Cart::getTotal() + $biaya_layanan, 
                    // 'total_price' =>  \Cart::getTotal(), 
                    'total_price' => \Cart::getTotal() + $biaya_layanan, 
                    'status_pembayaran' => 'Unpaid',
                    'invoice_no' => $newInvoiceNumber,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);

                foreach ($session_cart as $key => $item) {
                    // dd($item->attributes);
                    // $order = Order::get();
                    
                    $orderPivot = [];
                    if ($item->conditions == 'Restaurant') {
                        # code...
                            $orderPivot[] = [
                                'order_id' => $order->id,
                                'restaurant_id' => $item->associatedModel->id,
                                // 'paket_menu_id' => $item->id,
                                'category' => 'Restaurant',
                                'qty' => $item->quantity,
                            ];
                        } else {
                            $orderPivot[] = [
                                'order_id' => $order->id,
                                'restaurant_id' => null,
                                'paket_menu_id' => $item->id,
                                'category' => 'Paket Menu',
                                'qty' => $item->quantity,
                            ];
                        # code...
                    }
                    
                    // }
                    // dd($orderPivot);
                    OrderPivot::insert($orderPivot);
                }
          }
        
       
        // dd(\Cart::getTotalQuantity());


        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = true;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;
        // dd(number_format($order->total_price, 0));
        if (Auth::user()->membership->level == 'Super Platinum') {
            # code...
            $params = array(
                'transaction_details' => array(
                    'order_id' => $order->id,
                    // 'gross_amount' => $order->total_price,
                    'gross_amount' => 1,
                ),
                'customer_details' => array(
                    'first_name' => auth()->user()->name,
                    'phone' => $request->phone,
                    // 'code' => rand(),
                ),
            );
        } else {
            $params = array(
                'transaction_details' => array(
                    'order_id' => $order->id,
                    // 'gross_amount' => $order->total_price,
                    'gross_amount' => str_replace(',','',number_format($order->total_price, 0)),
                ),
                'customer_details' => array(
                    'first_name' => auth()->user()->name,
                    'phone' => $request->phone,
                    // 'code' => rand(),
                ),
            );
            # code...
        }
        
        
        $snapToken = \Midtrans\Snap::getSnapToken($params);
        // dd($snapToken);
        $data['data_carts'] = \Cart::session(Auth::user()->id)->getContent();
        $data['orders'] = Order::get();
        return view('checkout.index',$data,compact('snapToken','order'));
    }

    public function callback(Request $request)
    {
        $serverKey =  config('midtrans.server_key');
        $hashed = hash('sha512',$request->order_id.$request->status_code.$request->gross_amount.$serverKey);

        if ($hashed == $request->signature_key) {
            if ($request->transaction_status == 'capture' or $request->transaction_status == 'settlement') {
                $order = Order::find($request->order_id);
                $order->update(['status_pembayaran' => 'Paid']);

                // Get User ID

                $orderFinishSubtotal = Order::where('user_id', $order->user_id)->where('status_pembayaran','Paid')->sum('total_price');
                
                $user = User::find($order->user_id);
                if ($user) {
                    if ($orderFinishSubtotal >= 1 && $orderFinishSubtotal < 2) {
                        $user->membership_id = 2;
                    } elseif ($orderFinishSubtotal >= 2 && $orderFinishSubtotal < 5) {
                        $user->membership_id = 3;
                    } elseif ($orderFinishSubtotal >= 5 && $orderFinishSubtotal < 10000000) {
                        $user->membership_id = 4;
                    } elseif ($orderFinishSubtotal >= 10000000) {
                        $user->membership_id = 5;
                    } else {
                        $user->membership_id = 1;
                    }
                    $user->save();
                }

                // switch ($orderFinishSubtotal) {
                //     case ($orderFinishSubtotal >= 1):
                //         User::where('id', $order->user_id)->update(['membership_id' => 2]);
                //         break;
                //     case ($orderFinishSubtotal >= 2):
                //         User::where('id', $order->user_id)->update(['membership_id' => 3]);
                //         break;
                //     case ($orderFinishSubtotal >= 5):
                //         User::where('id', $order->user_id)->update(['membership_id' => 4]);
                //         break;
                //     case ($orderFinishSubtotal >= 10000000):
                //         User::where('id', $order->user_id)->update(['membership_id' => 5]);
                //         break;
                //     default:
                //         User::where('id', $order->user_id)->update(['membership_id' => 1]);
                //         break;
                // }

            }
        }

    }

    public function invoice($id)
    {
        // dd('tes');
        $order = Order::find($id);
        return view('checkout.invoice',compact('order'));
    }

    public function successOrder(Request $request){

        $datas = [];
        // try {
        //     $getRequest = $request->all(); 
        //     if ($getRequest) {
        //         foreach ($getRequest['data_menu'] as $key => $data) {
        //             // $order = Order::get();
        //             $orderPivot = [];
        //             // foreach ($request->all() as $key => $value) {
            
        //                 $orderPivot[] = [
        //                     'order_id' => $getRequest['order_id'],
        //                     'restaurant_id' => $data['id'],
        //                     'created_at' => date('Y-m-d H:i:s'),
        //                 ];
        //             // }
        //             OrderPivot::insert($orderPivot);
        //         }
        //         $response['success'] = true;
        //         $response['code'] = 200;
        //         $response['message'] = 'Success order...';
        //     }
        // } catch (\Throwable $th) {
        //     $response['success'] = false;
        //     $response['code'] = 500;
        //     $response['message'] = 'Upss... ' . $th->getMessage();
        //     //throw $th;
        // }
        // return $response;
    }

    public function xenditOrder(Request $request )
    {
        $data = $request->external_id;
        $data = $request->bank_code;
        $data = $request->name;
        
        Xendit::setApiKey('xnd_development_xKxZDSjXGvKcqTJR19iqbANl4Ocr9Oc7IRDt8SiTq3lA43XSdKaCE2N1klQYmx');

        // base64_encode($xendit);
        // $params = [
        //     'external_id' => $request->external_id,
        //     'bank_code' => $request->bank_code,
        //     'name' => $request->name,
        //     // 'checkout_method' => 'ONE_TIME_PAYMENT',
        //     // 'channel_code' => 'ID_SHOPEEPAY',
        //     // 'channel_properties' => [
        //     //     'success_redirect_url' => 'http://vmondcafe.test/callback-xendit',
        //     // ],
        //     // 'metadata' => [
        //     //     'branch_code' => 'tree_branch'
        //     // ]
        // ];
        // $createEWalletCharge = \Xendit\VirtualAccounts::create($params);

        // dd($createEWalletCharge);
// dd($request->all());
        // $params = [ 
        //     'external_id' => 'demo_1475801962607',
        //     'amount' => $request->amount,
        //     'description' => $request->description,
        //     'invoice_duration' => 86400,
        //     'customer' => [
        //         'given_names' => $request->given_names,
        //         'surname' => 'Doe',
        //         'email' => $request->payer_email,
        //         'mobile_number' => $request->mobile_phone,
        //         'addresses' => [
        //             [
        //                 'city' => 'Jakarta Selatan',
        //                 'country' => 'Indonesia',
        //                 'postal_code' => '12345',
        //                 'state' => 'Daerah Khusus Ibukota Jakarta',
        //                 'street_line1' => 'Jalan Makan',
        //                 'street_line2' => 'Kecamatan Kebayoran Baru'
        //             ]
        //         ]
        //     ],
        //     'customer_notification_preference' => [
        //         'invoice_created' => [
        //             'whatsapp',
        //             'sms',
        //             'email',
        //             'viber'
        //         ],
        //         'invoice_reminder' => [
        //             'whatsapp',
        //             'sms',
        //             'email',
        //             'viber'
        //         ],
        //         'invoice_paid' => [
        //             'whatsapp',
        //             'sms',
        //             'email',
        //             'viber'
        //         ],
        //         'invoice_expired' => [
        //             'whatsapp',
        //             'sms',
        //             'email',
        //             'viber'
        //         ]
        //     ],
        //     'success_redirect_url' => 'http://vmondcafe.test/callback-xendit-success',
        //     'failure_redirect_url' => 'http://vmondcafe.test/callback-xendit/Failed',
        //     'currency' => 'IDR',
        //     'items' => [
        //         [
        //             'name' => $request->name,
        //             'quantity' => 1,
        //             'price' => $request->price,
        //             'category' => 'Electronic',
        //         ]
        //     ],
        //   ];
        
        //   $createInvoice = \Xendit\Invoice::create($params);

        $params = [
            'reference_id' => 'test-reference-id',
            'currency' => 'IDR',
            'amount' => 1000,
            'checkout_method' => 'ONE_TIME_PAYMENT',
            'channel_code' => 'ID_SHOPEEPAY',
            'channel_properties' => [
                'success_redirect_url' => 'http://vmondcafe.test/callback-xendit-success',
            ],
            'metadata' => [
                'branch_code' => 'tree_branch'
            ]
        ];
        
        $createEWalletCharge = \Xendit\EWallets::createEWalletCharge($params);
        var_dump($createEWalletCharge);
        //   var_dump($createInvoice);
          $payment_url = $createEWalletCharge['id'];
          return redirect(url('https://checkout-staging.xendit.co/v2/'.$payment_url));
    }

    public function success()
    {
        return 'Pembayaran anda berhasil';
    }
    public function callbackXendit()
    {
        return view('checkout.tes');
    }
}
