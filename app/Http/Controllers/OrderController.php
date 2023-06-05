<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderPivot;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class OrderController extends Controller
{
    public function index()
    {

        return view('checkout.order',$data);
    }

    public function checkout(Request $request)
    {
        $request->request->add(['qty' => $request->qty]);
        // dd($request->request->add(['qty' => $request->qty]));
        $biaya_layanan = 5000;
        $session_cart = \Cart::session(Auth::user()->id)->getContent();
        $price = 1;

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
        
        $order = Order::create([
            // $request->all()
            'user_id' => auth()->user()->id,
            'name' => auth()->user()->username,
            'qty' => $request->qty,
            'code' => $newInvoiceNumber,
            // 'total_price' => \Cart::getTotal() *11/100 + \Cart::getTotal() + $biaya_layanan, 
            'total_price' =>  \Cart::getTotal(), 
            'status' => 'Unpaid',
            'invoice_no' => $newInvoiceNumber,
        ]);
        // dd(\Cart::getTotalQuantity());


        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = true;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $order->id,
                'gross_amount' => $order->total_price,
            ),
            'customer_details' => array(
                'first_name' => auth()->user()->name,
                'phone' => $request->phone,
                // 'code' => rand(),
            ),
        );

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
                $order->update(['status' => 'Paid']);

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
        // dd($request->all());
        // $orderPivot = OrderPivot::create() 
        // dd($request->all());

        // $order = Order::get();
        // $restaurant = Restaurant::get();
        // try {
        //     $orderRestaurant = [];
        //     // if ($request->restaurant_id) {
        //         foreach ($request->tag_id as $key => $value) {

        //             $orderRestaurant[] = [
        //                 'order_id' => $order->id,
        //                 'restaurant_id' => $restaurant->id,
        //             ];
        //         }
                
        //         OrderPivot::insert($orderRestaurant);
        //         // }
                
        //         $response['success'] = true;
        //         $response['code'] = 200;
        //         $response['message'] = 'Success order...';

        //     return $request[19]['id'];
        // } catch (\Throwable $th) {
        //     $response['success'] = false;
        //     $response['code'] = 500;
        //     $response['message'] = 'Upss... ' . $th->getMessage();
        //     //throw $th;
        // }

        // try {
            
        //     $orderPivot = [];
        //     foreach ($request[19]['id'] as $key => $value) {

        //         $orderPivot[] = [
        //             'restaurant_id' => $request[19]['id'],
        //             // 'order_id' => $request->tag_id,
        //         ];
        //     }
        //     return $orderPivot;
        //     OrderPivot::insert($orderPivot);
            
        //     // return redirect()->route('restaurant.index')->with(['success' => 'Restaurant added successfully!']);
        // } catch (\Throwable $th) {
        //     // return redirect()->route('restaurant.index')->with(['failed' => 'Restaurant added failed! '.$th->getMessage()]);
        // }

        $datas = [];
        
        try {
            $getRequest = $request->all(); 
            if ($getRequest) {
                foreach ($getRequest['data_menu'] as $key => $data) {
                    // $order = Order::get();
                    $orderPivot = [];
                    // foreach ($request->all() as $key => $value) {
            
                        $orderPivot[] = [
                            'order_id' => $getRequest['order_id'],
                            'restaurant_id' => $data['id'],
                        ];
                    // }
                    OrderPivot::insert($orderPivot);
                }
                $response['success'] = true;
                $response['code'] = 200;
                $response['message'] = 'Success order...';
            }
        } catch (\Throwable $th) {
            $response['success'] = false;
            $response['code'] = 500;
            $response['message'] = 'Upss... ' . $th->getMessage();
            //throw $th;
        }
        return $response;
    }
}
