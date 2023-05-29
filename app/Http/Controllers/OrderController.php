<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Cart;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    public function index()
    {
        return view('checkout.order');
    }

    public function checkout(Request $request)
    {
        // $request->request->add(['total_price' => $request->qty * 1, 'status' => 'Unpaid']);
        $biaya_layanan = 5000;
        $session_cart = \Cart::session(Auth::user()->id)->getContent();
        $price = 0;
        foreach ($session_cart as $key => $value) {
            $price +=$value->price;
        }
        $order = Order::create([
            // $request->all()
            'name' => auth()->user()->username,
            // 'phone' => $request->phone,
            'qty' => $request->qty,
            // 'total_price' => \Cart::getTotal() *11/100 + \Cart::getTotal() + $biaya_layanan, 
            'total_price' =>  \Cart::getTotal(), 
            'status' => 'Unpaid'
        ]);

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
        return view('checkout.index',compact('snapToken','order'));
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
}
