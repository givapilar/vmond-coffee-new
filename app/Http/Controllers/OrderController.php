<?php

namespace App\Http\Controllers;

use App\Models\AddOn;
use App\Models\AddOnDetail;
use App\Models\Membership;
use App\Models\Order;
use App\Models\OrderAddOn;
use App\Models\OrderBilliard;
use App\Models\OrderMeetingRoom;
use App\Models\OrderPivot;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\OtherSetting;
use App\Models\Voucher;
use Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Xendit\Xendit;
// use Illuminate\Support\Facades\DB;
use DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Writer;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
class OrderController extends Controller
{
    public function createQris(){
        $data1 = "00020101021226620017ID.CO.BANKBJB.WWW01189360011030001393800208001393800303UMI51470017ID.CO.BANKBJB.WWW0215ID12312312938560303UMI5204581253033605405200005802ID5912Vmond Coffee6007Bandung61051232262510124QRIS2023090715063500717102120817171819880703C026304DD65";
        $data2 = "00020101021226620017ID.CO.BANKBJB.WWW01189360011030001393800208001393800303UMI51470017ID.CO.BANKBJB.WWW0215ID12312312938560303UMI5204581253033605405200005802ID5912Vmond Coffee6007Bandung61051232262510124QRIS2023090710413900715002120817171819880703C026304807A";
        $data3 = "00020101021226620017ID.CO.BANKBJB.WWW01189360011030001393800208001393800303UMI51470017ID.CO.BANKBJB.WWW0215ID12312312938560303UMI5204581253033605405300005802ID5912Vmond Coffee6007Bandung61051232262510124QRIS2023090710443500715102120817171819880703C026304914A";
        $data4 = "00020101021226620017ID.CO.BANKBJB.WWW01189360011030001393800208001393800303UMI51470017ID.CO.BANKBJB.WWW0215ID12312312938560303UMI5204581253033605405400005802ID5912Vmond Coffee6007Bandung61051232262510124QRIS2023090710473800715202120817171819880703C026304018A";
        $data5 = "00020101021226620017ID.CO.BANKBJB.WWW01189360011030001393800208001393800303UMI51470017ID.CO.BANKBJB.WWW0215ID12312312938560303UMI5204581253033605405500005802ID5912Vmond Coffee6007Bandung61051232262510124QRIS2023090710510400715402120817171819880703C026304C981";
        $data6 = "00020101021226620017ID.CO.BANKBJB.WWW01189360011030001393800208001393800303UMI51470017ID.CO.BANKBJB.WWW0215ID12312312938560303UMI5204581253033605405600005802ID5912Vmond Coffee6007Bandung61051232262510124QRIS2023090710525400715502120817171819880703C026304A4BB";
        $dataExpired = "00020101021226620017ID.CO.BANKBJB.WWW01189360011030001393800208001393800303UMI51470017ID.CO.BANKBJB.WWW0215ID12312312938560303UMI5204581253033605405350005802ID5912Vmond Coffee6007Bandung61051232262510124QRIS2023090710551200715602120817171819880703C0263048E46";

        // Generate QR Code
        return QrCode::encoding('UTF-8')
            ->size(400)
            ->margin(10)
            ->generate($data1);
    }
    public function checkout(Request $request, $token)
    {
        try {
            $session_cart = \Cart::session(Auth::user()->id)->getContent();
            $other_setting = OtherSetting::get();

            // dd($request->all());
            $packing = 5000;
            
            $checkToken = Order::where('token',$token)->where('status_pembayaran', 'Paid')->get();
            if (count($checkToken) != 0) {
                return redirect()->route('homepage')->with(['failed' => 'Tidak dapat mengulang transaksi!']);
            }

            if($request->category == 'Dine In' && $request->meja_restaurant_id == null){
                return redirect()->back()->with(['failed' => 'Harap Isi Meja !']);
            }elseif($request->category == 'Takeaway' && $request->meja_restaurant_id == null) {
                return redirect()->back()->with(['failed' => 'Harap Isi Meja !']);
            }
            
            if ($request->tipe_pemesanan == 'Edisi' && $request->metode_edisi == null) {
                return redirect()->back()->with(['failed' => 'Harap Pilih EDC !']);
            }

            // if ($request->kasir_id == null) {
            //     return redirect()->back()->with(['failed' => 'Harap Isi Nama Kasir !']);
            // }

            $restaurants = Restaurant::get();

            $idSessions = $request->idSession;
            $qtys = $request->qty;

            foreach ($idSessions as $key => $id) {
                $qty = $qtys[$key];

                \Cart::session(Auth::user()->id)->update($id, [
                    'quantity' => array(
                        'relative' => false,
                        'value' => $qty
                    ),
                ]);
            }
            
            $price = 1;
            

            foreach ($session_cart as $key => $value) {
                $price +=$value->price;
            }

            // Replace the 'foreach' loop with a more efficient 'foreach' loop using collections.
            foreach ($session_cart as $key => $item) {
                // $restaurant = $restaurants->where('id', $key)->first();
                $restaurant = $restaurants->where('id', $item->attributes['restaurant']['id'])->first();
                // dd($restaurant->current_stok);
                
                if ($restaurant && $restaurant->current_stok < $item->quantity) {
                    return redirect()->route('cart')->with(['failed' => 'Stok ' . $item->name . ' Kurang!']);
                }
            }
        
            $time_to = date('Y-m-d', strtotime($request->date)) . ' ' . date('H:i', strtotime($request->time_from . ' + ' . $request->jam . ' hours - 2 minutes'));
            $time_from = date('Y-m-d', strtotime($request->date)) . ' ' . date('H:i', strtotime($request->time_from));
            if (Auth::check()) {
                $total_price = 1;

                if (Auth::user()->membership->level == 'Super Platinum') {
                    $total_price = 1;
                    // $total_price = (\Cart::getTotal() + ((\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100)) + ((\Cart::getTotal()  ?? '0') + (\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100) * $other_setting[0]->pb01/100;
                    $service = (\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100;
                    $pb01 = ((\Cart::getTotal()  ?? '0') + (\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100) * $other_setting[0]->pb01/100;
                    $name = auth()->user()->username;
                    $phone = auth()->user()->telephone;
                    $nama_kasir = null;
                }else if(Auth::user()->telephone == '081818181847') {
                    $total_price = (\Cart::getTotal() + ((\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100)) + ((\Cart::getTotal()  ?? '0') + (\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100) * $other_setting[0]->pb01/100;
                    $service = (\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100;
                    $pb01 = ((\Cart::getTotal()  ?? '0') + (\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100) * $other_setting[0]->pb01/100;
                    $name = $request->nama ?? 'Not Name';
                    $phone = $request->phone ?? '-';
                    // $kasir = $request->kasir_id;
                    $nama_kasir = $request->kasir_id;
                
                }else if(Auth::user()->is_worker == true) {
                        $total_price = (\Cart::getTotal() + ((\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100)) + ((\Cart::getTotal()  ?? '0') + (\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100) * $other_setting[0]->pb01/100;
                        $service = (\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100;
                        $pb01 = ((\Cart::getTotal()  ?? '0') + (\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100) * $other_setting[0]->pb01/100;
                        $name = $request->nama ?? 'Not Name';
                        $phone = $request->phone ?? '-';
                        // $kasir = $request->kasir_id;
                        $nama_kasir = $request->kasir_id;
                    
                }elseif (Auth::user()->telephone == '081210469621') {
                    $discount = (\Cart::getTotal() + ((\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100)) + ((\Cart::getTotal()  ?? '0') + (\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100) * $other_setting[0]->pb01/100;
                    $count = 0.2 * $discount;
                    $total_price = $discount - $count;
                    $service = (\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100;
                    $pb01 = ((\Cart::getTotal()  ?? '0') + (\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100) * $other_setting[0]->pb01/100;
                    $name = auth()->user()->username ?? 'Not Name';
                    // $name = $request->nama ?? 'Not Name';
                    $phone = $request->phone ?? '-';
                    $nama_kasir = null;
                }elseif (Auth::user()->username == 'syahrul') {
                    // $total_price = 1;
                    $total_price = (\Cart::getTotal() + ((\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100)) + ((\Cart::getTotal()  ?? '0') + (\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100) * $other_setting[0]->pb01/100;
                    // if ($request->category == "Takeaway") {
                    //     $packing = 5000;
                    //     $total_price = (\Cart::getTotal() + ((\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100)) + ((\Cart::getTotal()  ?? '0') + (\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100) * $other_setting[0]->pb01/100 + $packing;
                    // }else{
                    //     $total_price = $request->order_total;
                    // }
                    $service = (\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100;
                    $pb01 = ((\Cart::getTotal()  ?? '0') + (\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100) * $other_setting[0]->pb01/100;
                    $name = auth()->user()->username ?? 'Not Name';
                    $phone = $request->phone ?? '-';
                    $kasir = $request->kasir_id;
                    $nama_kasir = $request->kasir_id;
                }else{
                    if ($request->category == "Takeaway") {
                        $packing = 5000;
                        $totalWithoutPacking = (\Cart::getTotal() + ((\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100)) + ((\Cart::getTotal()  ?? '0') + (\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100) * $other_setting[0]->pb01/100;
                        $total_price = $totalWithoutPacking + $packing;
                    }else{
                        $total_price = (\Cart::getTotal() + ((\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100)) + ((\Cart::getTotal()  ?? '0') + (\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100) * $other_setting[0]->pb01/100;
                    }
                    // if ($request->category == "Takeaway") {
                    //     $packing = 5000;
                    //     $total_price = (\Cart::getTotal() + ((\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100)) + ((\Cart::getTotal()  ?? '0') + (\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100) * $other_setting[0]->pb01/100 + $packing;
                    // }else{
                    //     $total_price = $request->order_total;
                    // }
                    $service = (\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100;
                    $pb01 = ((\Cart::getTotal()  ?? '0') + (\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100) * $other_setting[0]->pb01/100;
                    $name = auth()->user()->username;
                    $phone = auth()->user()->telephone;
                    $kasir = null;
                    $nama_kasir = null;
                }
            }
                
                $order = Order::create([
                    'user_id' => auth()->user()->id,
                    'name' => $name,
                    'phone' => $phone,
                    'qty' => array_sum($request->qty),
                    'code' => 'draft',
                    'date' => $request->date,
                    'category' => $request->category,
                    'time_from' => $time_from,
                    'time_to' => $time_to,
                    'biliard_id' => $request->biliard_id,
                    'meeting_room_id' => $request->meeting_room_id,
                    // 'meja_restaurant_id' => $request->meja_restaurant_id,
                    'token' => $token,
                    'total_price' => $total_price, 
                    // 'total_price' => 1, 
                    'status_pembayaran' => 'Unpaid',
                    'status_pesanan' => 'process',
                    'tipe_pemesanan' => $request->tipe_pemesanan,
                    // 'kasir_id' => $kasir,
                    'invoice_no' => 'draft',
                    'created_at' => date('Y-m-d H:i:s'),
                    'service' => $service,
                    'pb01' => $pb01,
                    'packing' => $request->packing,
                    'nama_kasir' => $nama_kasir,
                    'kode_meja' => $request->meja_restaurant_id,
                    'metode_edisi' => $request->metode_edisi,
                    'voucher_diskon' => $request->voucher_diskon,
                    'jumlah_customer' => $request->jumlah_customer ?? 1,
                ]);

                    foreach ($session_cart as $key => $item) {
                        // dd($item);
                        $orderPivot = [];
                        if ($item->conditions == 'Restaurant') {
                            // $orderPivot[] = [
                            //     'order_id' => $order->id,
                            //     'restaurant_id' => $item->attributes['restaurant']['id'],
                            //     'category' => $item->attributes['restaurant']['category'],
                            //     'qty' => $item['quantity'],
                            // ];
                            // OrderPivot::insert($orderPivot);
                            $harga_diskon = array_sum((array) ($item->attributes['harga_add'] ?? [])) + ($item->attributes['restaurant']['harga_diskon'] ?? 0);


                            $order_pivot = new OrderPivot();
                            $order_pivot->order_id = $order->id;
                            $order_pivot->restaurant_id = $item->attributes['restaurant']['id'];
                            $order_pivot->category = $item->attributes['restaurant']['category'];
                            $order_pivot->qty = $item['quantity'];
                            $order_pivot->harga_diskon = $harga_diskon;

                            $order_pivot->save();

                            // $orderPivotId = DB::getPdo()->lastInsertId();
                            
                            if (is_iterable($item->attributes['harga_add']) && is_iterable($item->attributes['add_on_title'])) {
                                $orderAddOn = []; // Initialize the $orderAddOn array
                                foreach ($item->attributes['detail_addon_id'] as $innerKey => $detailAddonID) {
                                    // $detailcheck
                                    $detailAddonId = $item->attributes['detail_addon_id'][$innerKey];
                                    $dataaddondetail = AddOnDetail::where('id', $detailAddonId)->first();
                                    $dataaddon = AddOn::where('id', $dataaddondetail->add_on_id)->first();

                                    $order_add_on = new OrderAddOn();
                                    $order_add_on->order_pivot_id = $order_pivot->id;
                                    $order_add_on->add_on_id = $dataaddon->id;
                                    $order_add_on->add_on_detail_id = $detailAddonId;
                                    $order_add_on->save();

                                    // $orderAddOn[] = [
                                    //     'order_pivot_id' => $orderPivotId,
                                    //     'add_on_id' => $dataaddon->id,
                                    //     'add_on_detail_id' => $detailAddonId,
                                    // ];
                                }
                                // dd($request->all());
                                // OrderAddOn::insert($orderAddOn);
                            }
                        }
                    }

                // if($order->category == 'Dine In'){
                    
                //     if ($request->meja_restaurant_id == null) {
                //         return redirect()->back()->with(['failed' => 'Harap Isi Meja !']);
                //     }
                // }
                $checkToken2 = Order::where('token',$token)->get();
                $data['token'] = $checkToken2->pluck('token');

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
                $params = array(
                    'transaction_details' => array(
                        'order_id' => $order->id,
                        'gross_amount' => 1,
                    ),
                    'customer_details' => array(
                        'first_name' => auth()->user()->username,
                        'phone' => $request->phone,
                    ),
                );
            } else {
                $params = array(
                    'transaction_details' => array(
                        'order_id' => $order->id,
                        'gross_amount' => str_replace(',','',number_format($order->total_price, 0)),
                        // 'gross_amount' => 1,
                    ),
                    'customer_details' => array(
                        'first_name' => auth()->user()->username,
                        'phone' => $request->phone,
                    ),
                );
            }


            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $tokenCart = Order::where('token', $token)->first(); // Menggunakan first() karena Anda mencari satu record
            if ($tokenCart) {
                $data['data_carts'] = \Cart::session(Auth::user()->id)->getContent();
            }
            // $data['data_carts'] = \Cart::session(Auth::user()->id)->getContent();
            $data['order_last'] = Order::where('token', $token)->latest()->first();
            $data['order_settings'] = OtherSetting::get();

            $successMessage = $other_setting[0]->description_notifikasi;
            session()->flash('notifikasi', $successMessage);

            return view('checkout.index',$data,compact('snapToken','order'));
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('failed', $th->getMessage());
            // return redirect()->back()->with('failed', 'Silahkan Tanya Waiters');
        }
        
    }

    public function checkoutGuest(Request $request, $token)
    {
        // dd($request->all());
        try {
            $checkToken = Order::where('token',$token)->where('status_pembayaran', 'Paid')->get()->count();
            if ($checkToken != 0) {
                return redirect()->route('homepage')->with(['failed' => 'Tidak dapat mengulang transaksi!']);
            }

            // if ($request->meja_restaurant_id == null) {
            //     return redirect()->back()->with(['failed' => 'Harap Isi Meja !']);
            // }

            if($request->category == 'Dine In' && $request->meja_restaurant_id == null){
                return redirect()->back()->with(['failed' => 'Harap Isi Meja !']);
            }elseif($request->category == 'Takeaway' && $request->meja_restaurant_id == null) {
                return redirect()->back()->with(['failed' => 'Harap Isi Meja !']);
            }

            $idSessions = $request->idSession;
            $qtys = $request->qty;
            $userUpdate = 'guest';
            $session_cart = \Cart::session($userUpdate)->getContent();
            foreach ($idSessions as $key => $id) {
                $qty = $qtys[$key];

                \Cart::session($userUpdate)->update($id, [
                    'quantity' => [
                        'relative' => false,
                        'value' => $qty
                    ],
                ]);
            }
            foreach ($session_cart as $key => $item) {
                // dd($item);
                $checkCount = Restaurant::where('id', $item->attributes['restaurant']['id'])->get()->map(function ($resto) use ($item, $key) {
                    $count = $resto->where('id', $item->attributes['restaurant']['id'])->pluck('current_stok');
                    return (int)$count[0] <= $item->quantity;

                });

                if ($checkCount[0] == true) {
                    return redirect()->route('cart')->with(['failed' => 'Stok ' . $item->name .' Kurang !']);
                }
            }

            $user = User::where('telephone', $request->phone)->first();

            if (!$user) {
                $user = new User();
                $user->username = $request->nama;
                $user->telephone = $request->phone;
                $user->membership_id = 1;
                $user->password = Hash::make($request->phone);
                $user->save();
            }

            $request->request->add(['qty' => $request->qty]);
            $price = 1;

            foreach ($session_cart as $key => $value) {
                $price +=$value->price;
            }

            $other_setting = OtherSetting::get();
            // $other_setting = OtherSetting::first(); 
            
                $time_to = date('Y-m-d', strtotime($request->date)) . ' ' . date('H:i', strtotime($request->time_from . ' + ' . $request->jam . ' hours - 2 minutes'));
                $time_from = date('Y-m-d', strtotime($request->date)) . ' ' . date('H:i', strtotime($request->time_from));

                // if (Auth::user()->membership->level == 'Super Platinum') {
                if (Auth::check()) {
                    // $total_price = 1;
                    # code...
                    $user = auth()->user()->id;
                    if (Auth::auth()->id) {
                        $name = auth()->user()->username;
                    }else{
                        $name = $request->nama;
                        $phone = $request->phone;
                    }
                }else {
                    $total_price = (\Cart::getTotal() + ((\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100)) + ((\Cart::getTotal()  ?? '0') + (\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100) * $other_setting[0]->pb01/100;
                    $service = (\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100;
                    $pb01 = ((\Cart::getTotal()  ?? '0') + (\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100) * $other_setting[0]->pb01/100;
                    $user = '2';
                    if (Auth::check()) {
                        $name = auth()->user()->username;
                    }else{
                        $name = $request->nama;
                        $phone = $request->phone;
                    }
                }
                $order = Order::create([
                    'user_id' => $user,
                    // 'name' => auth()->user()->username,
                    'name' => $name,
                    'phone' => $phone,
                    'qty' => array_sum($request->qty),
                    'code' => 'draft',
                    'date' => $request->date,
                    'category' => $request->category,
                    'time_from' => $time_from,
                    'time_to' => $time_to,
                    'biliard_id' => $request->biliard_id,
                    'meeting_room_id' => $request->meeting_room_id,
                    // 'meja_restaurant_id' => $request->meja_restaurant_id,
                    'total_price' => $total_price, 
                    // 'total_price' => 1, 
                    'token' => $token, 
                    'status_pembayaran' => 'Unpaid',
                    'status_pesanan' => 'process',
                    'kasir_id' => null,
                    'tipe_pemesanan' => $request->tipe_pemesanan,
                    'invoice_no' => 'draft',
                    'created_at' => date('Y-m-d H:i:s'),
                    'service' => $service,
                    'pb01' => $pb01,
                    'jumlah_customer' => $request->jumlah_customer,
                    'kode_meja' => $request->meja_restaurant_id,
                ]);

                // dd($session_cart);
                foreach ($session_cart as $key => $item) {
                    $orderPivot = [];
                    if ($item->conditions == 'Restaurant') {
                        // $orderPivot[] = [
                        //     'order_id' => $order->id,
                        //     'restaurant_id' => $item->attributes['restaurant']['id'],
                        //     'category' => $item->attributes['restaurant']['category'],
                        //     'qty' => $item['quantity'],
                        // ];
                        // OrderPivot::insert($orderPivot);

                        $harga_diskon = array_sum((array) ($item->attributes['harga_add'] ?? [])) + ($item->attributes['restaurant']['harga_diskon'] ?? 0);

                        $order_pivot = new OrderPivot();
                        $order_pivot->order_id = $order->id;
                        $order_pivot->restaurant_id = $item->attributes['restaurant']['id'];
                        $order_pivot->category = $item->attributes['restaurant']['category'];
                        $order_pivot->qty = $item['quantity'];
                        $order_pivot->harga_diskon = $harga_diskon;

                        $order_pivot->save();

                        // $orderPivotId = DB::getPdo()->lastInsertId();
                        
                        if (is_iterable($item->attributes['harga_add']) && is_iterable($item->attributes['add_on_title'])) {
                            $orderAddOn = []; // Initialize the $orderAddOn array
                            foreach ($item->attributes['detail_addon_id'] as $innerKey => $detailAddonID) {
                                // $detailcheck
                                $detailAddonId = $item->attributes['detail_addon_id'][$innerKey];
                                $dataaddondetail = AddOnDetail::where('id', $detailAddonId)->first();
                                $dataaddon = AddOn::where('id', $dataaddondetail->add_on_id)->first();

                                $order_add_on = new OrderAddOn();
                                $order_add_on->order_pivot_id = $order_pivot->id;
                                $order_add_on->add_on_id = $dataaddon->id;
                                $order_add_on->add_on_detail_id = $detailAddonId;
                                $order_add_on->save();

                                // $orderAddOn[] = [
                                //     'order_pivot_id' => $orderPivotId,
                                //     'add_on_id' => $dataaddon->id,
                                //     'add_on_detail_id' => $detailAddonId,
                                // ];
                            }
                            // OrderAddOn::insert($orderAddOn);
                        }
                    }
                    
                }

                
                
                $checkToken2 = Order::where('token',$token)->get();
                $data['token'] = $checkToken2->pluck('token');

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
                    'gross_amount' => str_replace(',','',number_format($order->total_price, 0)),
                    // 'gross_amount' => 1,
                ),
                'customer_details' => array(
                    'first_name' => $request->nama,
                    'phone' => $request->phone,
                ),
            );


            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // $data['data_carts'] = \Cart::session(Auth::user()->id)->getContent();
            $user = 'guest';
            $data['data_carts'] = \Cart::session($user)->getContent();
            // $data['order_last'] = Order::latest()->first();
            $data['order_settings'] = OtherSetting::get();
            $data['users'] = User::first();
            $data['orders'] = Order::where('token',$token)->get()->first();

            
            if ($other_setting[0]->status_notifikasi == "Active") {
                $successMessage = $other_setting[0]->description_notifikasi;
                session()->flash('notifikasi', $successMessage);
            }

            return view('checkout.checkout-guest',$data,compact('snapToken','order'));
            // return view('checkout.checkout-guest',$data,compact('snapToken','order'))->with('success',$other_setting[0]->description_notifikasi . $request->total_lama_waktu);
            // return redirect()->route('checkout-order-guest',['token',$token])->with(['success' => $other_setting[0]->description_notifikasi . $request->total_lama_waktu],$data,compact('snapToken','order'));

        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('failed', $th->getMessage());

        }
        
    }
    
    public function index()
    {
        return view('checkout.order');
    }
    public function resetMeja(){
        try {
            // Dapatkan user yang sedang login
            $user = Auth::user();
            
            if ($user) {
                $user = Auth::user();
                // User tidak ditemukan, berikan tanggapan sesuai kebutuhan
                $user->kode_meja = null;
                $user->save();
                return redirect()->back()->with('success', 'Meja berhasil di hapus');
            }else{
                $user = Auth::guest();
                $user->kode_meja = null;
                $user->save();
            }
            return redirect()->back()->with('success', 'Data meja berhasil dihapus dari user.');
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi
            return redirect()->back()->with('failed', 'Terjadi kesalahan saat menghapus data meja.');
        }
    }

    public function checkoutWaiters(Request $request, $token){
        $checkToken = Order::where('token',$token)->where('status_pembayaran', 'Paid')->get()->count();
        if ($checkToken != 0) {
            return redirect()->route('homepage')->with(['failed' => 'Tidak dapat mengulang transaksi!']);
        }


        $latestOrder = Order::where('token',$token)->orderBy('id', 'desc')->first();

        // dd($latestOrder);
        if ($latestOrder) {
            // Ubah status pembayaran menjadi "Paid"
            $latestOrder->update(['status_pembayaran' => 'Paid', 'invoice_no' => $this->generateInvoice()]);

            $userID = $latestOrder->user_id;
            $cart = \Cart::session($userID)->getContent();

             // Menghapus item dari session cart
             foreach ($cart as $item) {
                \Cart::session($userID)->remove($item->id);
            }

            foreach ($cart as $key => $item) {
                $restoStock = Restaurant::where('id', $item->attributes['restaurant']['id'])->first();
                $stockAvailable = ($restoStock->current_stok - $item['quantity']);
                
                // Memperbarui stok restoran
                $restoStock->update(['current_stok' => $stockAvailable]);
            }

        }

        return redirect()->route('homepage')->with('success', 'Order Telah berhasil');

    }

    // public function checkout(Request $request)
    // {
    //     $request->request->add(['qty' => $request->qty]);
    //     $price = 1;
    //     $session_cart = \Cart::session(Auth::user()->id)->getContent();

    //     foreach ($session_cart as $key => $value) {
    //         $price +=$value->price;
    //     }
    //     $currentYear = date('YmdHis');
    //     $orderInvoice = Order::orderBy('id', 'desc')->first();

    //     if ($orderInvoice) {
    //         $lastInvoiceNumber = $orderInvoice->invoice_no;
    //         $lastInvoiceYear = substr($lastInvoiceNumber, 0, 4);

    //         if ($lastInvoiceYear == $currentYear) {
    //             $lastInvoiceIncrement = (int) substr($lastInvoiceNumber, 4);
    //             $newInvoiceNumber = $currentYear . str_pad($lastInvoiceIncrement + 1, 4, '0', STR_PAD_LEFT);
    //         } else {
    //             $newInvoiceNumber = $currentYear . '1';
    //         }
    //     } else {
    //         $newInvoiceNumber = $currentYear . '1';
    //     }

    //     $restaurant = Restaurant::get();
    //     $orderDetail = OrderPivot::get();
    //     $orders = Order::where('status_pembayaran', 'Paid')->get();
        
    //     $member = Membership::get();
    //     $other_setting = OtherSetting::get();
    //     // $other_setting = OtherSetting::first(); KOmentar pengingat untuk developer

    //     foreach ($session_cart as $key => $item) {
    //         $checkCount = Restaurant::where('id', $key)->get()->map(function ($resto) use ($item, $key) {
    //             $count = $resto->where('id', $key)->pluck('current_stok');
    //             return (int)$count[0] <= $item->quantity;

    //         });

    //         if ($checkCount[0] == true) {
    //             return redirect()->route('cart')->with(['failed' => 'Stok' . $item->name .' Kurang !']);
    //         }
    //     }
    //         $time_to = date('Y-m-d', strtotime($request->date)) . ' ' . date('H:i', strtotime($request->time_from . ' + ' . $request->jam . ' hours - 2 minutes'));
    //         $time_from = date('Y-m-d', strtotime($request->date)) . ' ' . date('H:i', strtotime($request->time_from));

    //         if (Auth::user()->membership->level == 'Super Platinum') {
    //             $order = Order::create([
    //                 'user_id' => auth()->user()->id,
    //                 'name' => auth()->user()->username,
    //                 'qty' => $request->qty,
    //                 'code' => $newInvoiceNumber,
    //                 'date' => $request->date,
    //                 'category' => $request->category,
    //                 'time_from' => $time_from,
    //                 'time_to' => $time_to,
    //                 'biliard_id' => $request->biliard_id,
    //                 'meeting_room_id' => $request->meeting_room_id,
    //                 'meja_restaurant_id' => $request->meja_restaurant_id,
    //                 'total_price' => 1, 
    //                 'status_pembayaran' => 'Unpaid',
    //                 'status_pesanan' => 'process',
    //                 'tipe_pemesanan' => $request->tipe_pemesanan,
    //                 'invoice_no' => $newInvoiceNumber,
    //                 'created_at' => date('Y-m-d H:i:s'),
    //             ]);
    //         } else {
    //             $biaya_layanan = 0;
    //             $order = Order::create([
    //                 'user_id' => auth()->user()->id,
    //                 'name' => auth()->user()->username,
    //                 'qty' => $request->qty,
    //                 'code' => $newInvoiceNumber,
    //                 'date' => $request->date,
    //                 'category' => $request->category,
    //                 'time_from' => $time_from,
    //                 'time_to' => $time_to,
    //                 'biliard_id' => $request->biliard_id,
    //                 'meeting_room_id' => $request->meeting_room_id,
    //                 'meja_restaurant_id' => $request->meja_restaurant_id,
    //                 'total_price' =>(\Cart::getTotal() + ((\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100)) + ((\Cart::getTotal()  ?? '0') + (\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100) * $other_setting[0]->pb01/100, 
    //                 'status_pembayaran' => 'Unpaid',
    //                 'status_pesanan' => 'process',
    //                 'tipe_pemesanan' => $request->tipe_pemesanan,
    //                 'invoice_no' => $newInvoiceNumber,
    //                 'created_at' => date('Y-m-d H:i:s'),
    //             ]);

    //             foreach ($session_cart as $key => $item) {
    //                 $orderPivot = [];
    //                 if ($item->conditions == 'Restaurant') {
    //                     $orderPivot[] = [
    //                         'order_id' => $order->id,
    //                         'restaurant_id' => $item->associatedModel->id,
    //                         'category' => $item->model->category,
    //                         'qty' => $item->quantity,
    //                     ];
    //                     OrderPivot::insert($orderPivot);

    //                     $orderPivotId = DB::getPdo()->lastInsertId();

    //                     if (is_iterable($item->attributes->harga_add) && is_iterable($item->attributes->add_on_title)) {
    //                         $orderAddOn = []; // Initialize the $orderAddOn array
    //                         foreach ($item->attributes->detail_addon_id as $innerKey => $detailAddonID) {
    //                             // $detailcheck
    //                             $detailAddonId = $item->attributes->detail_addon_id[$innerKey];
    //                             $dataaddondetail = AddOnDetail::where('id', $detailAddonId)->first();
    //                             $dataaddon = AddOn::where('id', $dataaddondetail->add_on_id)->first();
    //                             $orderAddOn[] = [
    //                                 'order_pivot_id' => $orderPivotId,
    //                                 'add_on_id' => $dataaddon->id,
    //                                 'add_on_detail_id' => $detailAddonId,
    //                             ];
    //                         }
                        
    //                         OrderAddOn::insert($orderAddOn);
    //                     }
                        
    //                 }elseif ($item->conditions == 'Paket Menu') {
    //                     $paketRestaurantIds = $item->attributes->paket_restaurant_id;
    //                     $paketRestoCategory = $item->attributes->category;
                        
    //                     $length = min(count($paketRestaurantIds), count($paketRestoCategory));
                        
    //                     for ($i = 0; $i < $length; $i++) {
    //                         $paketRestaurantId = $paketRestaurantIds[$i];
    //                         $category = $paketRestoCategory[$i];
                        
    //                         $orderBilliard[] = [
    //                             'order_id' => $order->id,
    //                             'restaurant_id' => $paketRestaurantId,
    //                             'paket_menu_id' => $item->id,
    //                             'category' => $category,
    //                             'qty' => $item->quantity,
    //                             'time_from' => $time_from,
    //                             'time_to' => $time_to,
    //                         ];
    //                     }
    //                     OrderBilliard::insert($orderBilliard);
    //                 } else{
    //                     $paketRestaurantIds = $item->attributes->paket_restaurant_id;
    //                     $paketRestoCategory = $item->attributes->category;
                        
    //                     $length = min(count($paketRestaurantIds), count($paketRestoCategory));
                        
    //                     for ($i = 0; $i < $length; $i++) {
    //                         $paketRestaurantId = $paketRestaurantIds[$i];
    //                         $category = $paketRestoCategory[$i];
                        
    //                         $orderMeeting[] = [
    //                             'order_id' => $order->id,
    //                             'restaurant_id' => $paketRestaurantId,
    //                             'paket_menu_id' => $item->id,
    //                             'category' => $category,
    //                             'qty' => $item->quantity,
    //                             'time_from' => $time_from,
    //                             'time_to' => $time_to,
    //                         ];
    //                     }
                        
    //                     OrderMeetingRoom::insert($orderMeeting);
                        
    //                 }
                    
    //             }
    //       }


    //     // Set your Merchant Server Key
    //     \Midtrans\Config::$serverKey = config('midtrans.server_key');
    //     // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
    //     \Midtrans\Config::$isProduction = true;
    //     // Set sanitization on (default)
    //     \Midtrans\Config::$isSanitized = true;
    //     // Set 3DS transaction for credit card to true
    //     \Midtrans\Config::$is3ds = true;
    //     // dd(number_format($order->total_price, 0));
    //     if (Auth::user()->membership->level == 'Super Platinum') {
    //         $params = array(
    //             'transaction_details' => array(
    //                 'order_id' => $order->id,
    //                 'gross_amount' => 1,
    //             ),
    //             'customer_details' => array(
    //                 'first_name' => auth()->user()->name,
    //                 'phone' => $request->phone,
    //             ),
    //         );
    //     } else {
    //         $params = array(
    //             'transaction_details' => array(
    //                 'order_id' => $order->id,
    //                 'gross_amount' => str_replace(',','',number_format($order->total_price, 0)),
    //             ),
    //             'customer_details' => array(
    //                 'first_name' => auth()->user()->name,
    //                 'phone' => $request->phone,
    //             ),
    //         );
    //     }


    //     $snapToken = \Midtrans\Snap::getSnapToken($params);
    //     $data['data_carts'] = \Cart::session(Auth::user()->id)->getContent();
    //     $data['order_last'] = Order::latest()->first();
    //     $data['order_settings'] = OtherSetting::get();
    //     return view('checkout.index',$data,compact('snapToken','order'));
    // }



    // public function callback(Request $request)
    // {
    //     $session_cart = \Cart::session(Auth::user()->id)->getContent();
    //     $serverKey =  config('midtrans.server_key');
    //     $hashed = hash('sha512',$request->order_id.$request->status_code.$request->gross_amount.$serverKey);

    //     if ($hashed == $request->signature_key) {
    //         if ($request->transaction_status == 'capture' or $request->transaction_status == 'settlement') {
    //             $order = Order::find($request->order_id);
    //             $order->update(['status_pembayaran' => 'Paid']);
    //             $restaurant = Restaurant::get();
    //             $orderDetail = OrderPivot::get();
    //             // foreach ($session_cart as $key => $item) {
    //             //     $restoStock = Restaurant::where('id',$key)->get()->first();
    //             //     $stockAvailable = ($restoStock->current_stok - $item->quantity);
    //             //     $restoStock->update(['current_stok' => $stockAvailable]);
    //             // }
    //             // Get User ID

                // $orderFinishSubtotal = Order::where('user_id', $order->user_id)->where('status_pembayaran','Paid')->sum('total_price');
                // $user = User::where('id',$order->user_id);
                // $memberships = Membership::orderBy('minimum_transaksi')->get();
                // if ($user) {
                //     // foreach ($memberships as $key => $member) {
                //     //     if ($orderFinishSubtotal <= $member->minimum_transaksi && $orderFinishSubtotal > $member->minimum_transaksi) {
                //     //         $user->membership_id = $member->id;
                //     //         $user->save();
                //     //     }
                //     // }
                //     if ($orderFinishSubtotal >= ($memberships[0]->minimum_transaksi - $memberships[0]->minimum_transaksi) && $orderFinishSubtotal <= $memberships[0]->minimum_transaksi) {
                //         $user->membership_id = $memberships[0]->id;
                //     } elseif ($orderFinishSubtotal > $memberships[0]->minimum_transaksi && $orderFinishSubtotal <= $memberships[1]->minimum_transaksi) {
                //         $user->membership_id = $memberships[1]->id;
                //     } elseif ($orderFinishSubtotal > $memberships[1]->minimum_transaksi && $orderFinishSubtotal <= $memberships[2]->minimum_transaksi) {
                //         $user->membership_id = $memberships[2]->id;
                //     } elseif ($orderFinishSubtotal > $memberships[2]->minimum_transaksi && $orderFinishSubtotal <= $memberships[3]->minimum_transaksi) {
                //         $user->membership_id = $memberships[3]->id;
                //     } elseif ($orderFinishSubtotal > $memberships[4]->minimum_transaksi) {
                //         $user->membership_id = $memberships[4]->id;
                //     }
                //         $user->save();

                // }

    //             // switch ($orderFinishSubtotal) {
    //             //     case ($orderFinishSubtotal >= 1):
    //             //         User::where('id', $order->user_id)->update(['membership_id' => 2]);
    //             //         break;
    //             //     case ($orderFinishSubtotal >= 2):
    //             //         User::where('id', $order->user_id)->update(['membership_id' => 3]);
    //             //         break;
    //             //     case ($orderFinishSubtotal >= 5):
    //             //         User::where('id', $order->user_id)->update(['membership_id' => 4]);
    //             //         break;
    //             //     case ($orderFinishSubtotal >= 10000000):
    //             //         User::where('id', $order->user_id)->update(['membership_id' => 5]);
    //             //         break;
    //             //     default:
    //             //         User::where('id', $order->user_id)->update(['membership_id' => 1]);
    //             //         break;
    //             // }

    //         }
    //     }

    // }

    public function callback(Request $request)
    {
        
        $serverKey =  config('midtrans.server_key');
        $hashed = hash('sha512',$request->order_id.$request->status_code.$request->gross_amount.$serverKey);
        if ($hashed == $request->signature_key) {
            if ($request->transaction_status == 'capture' or $request->transaction_status == 'settlement') {
                $order = Order::find($request->order_id);
                $paymentType = $request->payment_type;
                
                $order->update(['status_pembayaran' => 'Paid','invoice_no' => $this->generateInvoice(), 'metode_pembayaran' => $paymentType]);
                // Get User ID

                $orderFinishSubtotal = Order::where('user_id', $order->user_id)->where('status_pembayaran','Paid')->sum('total_price');

                // $user = User::find($order->user_id);
                // if ($user) {
                //     if ($orderFinishSubtotal >= 1 && $orderFinishSubtotal < 2) {
                //         $user->membership_id = 2;
                //     } elseif ($orderFinishSubtotal >= 2 && $orderFinishSubtotal < 5) {
                //         $user->membership_id = 3;
                //     } elseif ($orderFinishSubtotal >= 5 && $orderFinishSubtotal < 10000000) {
                //         $user->membership_id = 4;
                //     } elseif ($orderFinishSubtotal >= 10000000) {
                //         $user->membership_id = 5;
                //     } else {
                //         $user->membership_id = 1;
                //     }
                //     $user->save();
                // }

                $user = User::where('id', $order->user_id)->first(); // Gunakan first() untuk mendapatkan objek user
                $memberships = Membership::orderBy('id','asc')->get();
                $user_member = User::where('membership_id',5)->get()->first();

                // foreach ($user_member as $key => $value) {
                    if (!$user_member) {
                        // $user->membership_id = 5;
                        // $user->save();
                        if ($user) {
                            if ($orderFinishSubtotal < $memberships[1]->minimum_transaksi) {
                                $user->membership_id = $memberships[0]->id;
                            } elseif ($orderFinishSubtotal >= $memberships[1]->minimum_transaksi && $orderFinishSubtotal < $memberships[2]->minimum_transaksi) {
                                $user->membership_id = $memberships[1]->id;
                            } elseif ($orderFinishSubtotal >= $memberships[2]->minimum_transaksi && $orderFinishSubtotal < $memberships[3]->minimum_transaksi) {
                                $user->membership_id = $memberships[2]->id;
                            } elseif ($orderFinishSubtotal >= $memberships[3]->minimum_transaksi && $orderFinishSubtotal < $memberships[4]->minimum_transaksi) {
                                $user->membership_id = $memberships[3]->id;
                            } elseif ($orderFinishSubtotal >= $memberships[4]->minimum_transaksi) {
                                $user->membership_id = $memberships[4]->id;
                            }
                
                            $user->save();
                        }
                    }
                    
                // }
                
                

                

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

    public function checkoutBilliard(Request $request, $token){
        // dd($request->all());
        $checkToken = Order::where('token',$token)->where('status_pembayaran', 'Paid')->get();
        if (count($checkToken) != 0) {
            return redirect()->route('homepage')->with(['failed' => 'Tidak dapat mengulang transaksi!']);
        }

        if ($request->time_from == null) {
            return redirect()->back()->with(['failed' => 'Harap Isi Jam !']);
        }

        if ($request->billiard_id == null) {
            return redirect()->back()->with(['failed' => 'Harap Isi Meja Billiard !']);
        }

        if ($request->paket_restaurant_id == null) {
            return redirect()->back()->with(['failed' => 'Harap Pilih Menu !']);
        }

        if ($request->tipe_pemesanan == 'Edisi' && $request->metode_edisi == null) {
            return redirect()->back()->with(['failed' => 'Harap Pilih EDC !']);
        }
        
        $selectedPackages = $request->input('paket_restaurant_id');

        foreach ($selectedPackages as $groupIdentifier => $restaurantId) {
            // Extract the numeric portion from the groupIdentifier
            $menuItemIndex = (int) str_replace('menu_', '', $groupIdentifier);

            $restaurant = Restaurant::findOrFail($restaurantId);

            if ($restaurant->current_stok <= 0) {
                return redirect()->back()->with(['failed' => 'Stok ' . $restaurant->nama . ' Kurang!, Silahkan pilih yang lain']);
            }

            // Process the selected package
            // ... (your existing code to process the selected package)
        }
        // generate Invoice NO
        $today = Carbon::today();
        $formattedDate = $today->format('ymd');

        $lastOrder = Order::whereDate('created_at',$today)->orderBy('id','desc')->first();
        if ($lastOrder) {
            // Cek apakah order dibuat pada tanggal yang sama dengan hari ini
            $lastInvoiceNumber = $lastOrder->invoice_no;
            $lastOrderNumber = (int)substr($lastInvoiceNumber, 7);
            $nextOrderNumber = $lastOrderNumber + 1;
            // dd($nextOrderNumber);
        } else {
            $nextOrderNumber = 1;
        }

        $paddedOrderNumber = str_pad($nextOrderNumber, 3, '0', STR_PAD_LEFT);
        $invoiceNumber = $formattedDate . '-' . $paddedOrderNumber;

        $data['other_setting'] = OtherSetting::get()->first();
        $other_setting = OtherSetting::get();
        $request->request->add(['qty' => $request->qty]);
            
        $restaurant = Restaurant::get();

        // if ($restaurant->current_stok <= 0) {
        //     return redirect()->back()->with(['failed' => 'Stok ' . $restaurant->name . ' Kurang!']);
        // }
            
            $member = Membership::get();
            $time_to = date('Y-m-d', strtotime($request->date)) . ' ' . date('H:i', strtotime($request->time_from . ' + ' . $request->jam . ' hours - 2 minutes'));
            $time_from = date('Y-m-d', strtotime($request->date)) . ' ' . date('H:i', strtotime($request->time_from));

            // Harga
            $harga = $request->total_paket;
            $layanan = (($request->total_paket ?? 0) * $other_setting[0]->layanan/100);
            // $pb01 = (($request->total_paket ?? 0) * $other_setting[0]->pb01/100);
            $pb01 = ($harga + $layanan) * ($other_setting[0]->pb01 / 100);
            $total_harga = $harga + $layanan + $pb01;

            // Passing Harga
            $data['harga'] = $harga;
            $data['layanan'] = $layanan;
            $data['pb01'] = $pb01;
            $data['total_harga'] = $total_harga;

        
            if (Auth::check()) {
                $total_price = 1;
                # code...
                // dd(Auth::user()->membership->level);
                if (Auth::user()->membership->level == 'Super Platinum') {
                    // dd('tes');
                    // $total_price = 1;
                    $total_price = (\Cart::getTotal() + ((\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100)) + ((\Cart::getTotal()  ?? '0') + (\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100) * $other_setting[0]->pb01/100;
                    $name = auth()->user()->username;
                    $phone = auth()->user()->telephone;
                    $kasir = null;
                    $nama_kasir = $request->kasir_id;
                    
                }else if(Auth::user()->telephone == '081818181847') {
                    $total_price = (\Cart::getTotal() + ((\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100)) + ((\Cart::getTotal()  ?? '0') + (\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100) * $other_setting[0]->pb01/100;
                    $name = $request->nama_customer ?? 'Not Name';
                    $phone = $request->phone ?? '-';
                    $nama_kasir = $request->kasir_id;
                
                }elseif (Auth::user()->telephone == '081210469621') {
                    $discount = (\Cart::getTotal() + ((\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100)) + ((\Cart::getTotal()  ?? '0') + (\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100) * $other_setting[0]->pb01/100;
                    $count = 0.2 * $discount;
                    $total_price = $discount - $count;
                    // dd($total_price);
                    $name = $request->nama_customer ?? 'Not Name';
                    $phone = $request->phone ?? '-';
                    $nama_kasir = null;
                    // $kasir = $request->kasir_id;
                    // $nama_kasir = $request->kasir_id;
                }
                else{
                    // dd('tes2');
                    $total_price = (\Cart::getTotal() + ((\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100)) + ((\Cart::getTotal()  ?? '0') + (\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100) * $other_setting[0]->pb01/100;
                    $name = auth()->user()->username;
                    $phone = auth()->user()->telephone;
                    $kasir = null;
                    $nama_kasir = null;
                    // $nama_kasir = $request->kasir_id;
                }
            }
                
                $order = Order::create([
                    'user_id' => auth()->user()->id,
                    'name' => $name,
                    'phone' => $phone,
                    'qty' => 1,
                    'code' => 'draft',
                    'date' => $request->date,
                    'category' => $request->category,
                    'time_from' => $time_from,
                    'time_to' => $time_to,
                    'biliard_id' => $request->billiard_id,
                    'meeting_room_id' => $request->meeting_room_id,
                    'meja_restaurant_id' => $request->meja_restaurant_id,
                    'token' => $token,
                    'total_price' => $total_harga, 
                    // 'total_price' => 1, 
                    'status_pembayaran' => 'Unpaid',
                    'status_lamp' => 'OFF',
                    'status_running' => 'NOT START',
                    'status_pesanan' => 'process',
                    'tipe_pemesanan' => $request->tipe_pemesanan,
                    // 'kasir_id' => $kasir,
                    'invoice_no' => 'draft',
                    'created_at' => date('Y-m-d H:i:s'),
                    'service' => $layanan,
                    'pb01' => $pb01,
                    'nama_kasir' => $nama_kasir,
                    'metode_edisi' => $request->metode_edisi,
                    'harga_diskon_billiard' => $request->harga_diskon_billiard,

                ]);
    

                if ($request->paket_restaurant_id) {
                    $orderBilliard = [];
                
                    // dd($request->paket_restaurant_id);
                    foreach ($request->paket_restaurant_id as $key => $value) {
                        $restaurant = Restaurant::find($value);
                        if ($restaurant) {
                            $category = $restaurant->category;
                            $orderBilliard[] = [
                                'order_id' => $order->id,
                                'restaurant_id' => $value,
                                'category' => $category,
                                'paket_menu_id' => $request->paket_menu_id[0],
                                'qty' => $request->quantity, // Use $key to access the corresponding quantity
                                'time_from' => $time_from,
                                'time_to' => $time_to,
                            ];
                        }
                    }
                    // dd($orderBilliard);
                    OrderBilliard::insert($orderBilliard);
                }
                    // $orderBilliardId = DB::getPdo()->lastInsertId();
                    // if ($request->paket_restaurant_id) {
                    //     # code...
                    //     $orderAddOn = []; // Initialize the $orderAddOn array
                    //     foreach ($request->paket_restaurant_id as $innerKey => $detailAddonID) {
                    //         $detailAddonId = $request->harga_add_menu [$innerKey];
                    //         $dataaddondetail = AddOnDetail::where('id', $detailAddonId)->first();
                    //         $dataaddon = AddOn::where('id', $dataaddondetail->add_on_id)->first();

                    //         $orderAddOn[] = [
                    //             'order_billiard_id' => $orderBilliardId,
                    //             'add_on_id' => $dataaddon->id,
                    //             'add_on_detail_id' => $detailAddonId,
                    //         ];
                    //     }
                    //     OrderAddOn::insert($orderAddOn);
                    // }
                    // dd($request->all());

                    // dd($request->harga_addmenu_1);
                    // $orderBilliardId = DB::getPdo()->lastInsertId();
                    // if ($request->paket_restaurant_id) {
                    //     $orderAddOn = []; // Initialize the $orderAddOn array
                    
                    //     foreach ($request->harga_addmenu_1 as $groupIdentifier => $selectedItemID) {
                    //         list($groupIdentifier, $addOnID) = explode('_', $groupIdentifier);
                            
                    //         $dataaddondetail = AddOnDetail::where('id', $selectedItemID)->first();
                    //         $dataaddon = AddOn::where('id', $addOnID)->first();
                    
                    //         $orderAddOn[] = [
                    //             'order_billiard_id' => $orderBilliardId,
                    //             'add_on_detail_id' => $selectedItemID,
                    //         ];
                    //     }
                    
                    //     OrderAddOn::insert($orderAddOn);
                    // }

            $checkToken2 = Order::where('token',$token)->get();
            $data['token'] = $checkToken2->pluck('token');

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
                    'first_name' => auth()->user()->username,
                    'phone' => $request->phone,
                    // 'code' => rand(),
                ),
            );
        } else {
            $params = array(
                'transaction_details' => array(
                    'order_id' => $order->id,
                    // 'gross_amount' => $order->total_price,
                    // 'gross_amount' => str_replace(',','',number_format($order->total_price, 0)),
                    // 'gross_amount' => 1,
                    'gross_amount' => $total_harga,
                ),
                'customer_details' => array(
                    'first_name' => auth()->user()->username,
                    'phone' => $request->phone,
                    // 'code' => rand(),
                ),
            );
            # code...
        }


        $snapToken = \Midtrans\Snap::getSnapToken($params);
        // dd($snapToken);
        $data['data_carts'] = \Cart::session(Auth::user()->id)->getContent();
        // $data['orders'] = Order::get();
        $data['orders'] = Order::latest()->first();
        $data['order_last'] = Order::latest()->first();
        return view('checkout.billiard-index',$data,compact('snapToken','order'));
    }

    public function checkoutBilliardGuest(Request $request, $token){
        DB::beginTransaction();
        // dd($request->all());
        try {
            $checkToken = Order::where('token',$token)->where('status_pembayaran', 'Paid')->get();
            if (count($checkToken) != 0) {
                return redirect()->route('homepage')->with(['failed' => 'Tidak dapat mengulang transaksi!']);
            }
    
            if ($request->time_from == null) {
                return redirect()->back()->with(['failed' => 'Harap Isi Jam !']);
            }
    
            if ($request->billiard_id == null) {
                return redirect()->back()->with(['failed' => 'Harap Isi Meja Billiard !']);
            }
    
            if ($request->paket_restaurant_id == null) {
                return redirect()->back()->with(['failed' => 'Harap Pilih Menu !']);
            }
            
            $restaurant = Restaurant::get();

            $selectedPackages = $request->input('paket_restaurant_id');

            foreach ($selectedPackages as $groupIdentifier => $restaurantId) {
                // Extract the numeric portion from the groupIdentifier
                $menuItemIndex = (int) str_replace('menu_', '', $groupIdentifier);

                $restaurant = Restaurant::findOrFail($restaurantId);

                if ($restaurant->current_stok <= 0) {
                    return redirect()->back()->with(['failed' => 'Stok ' . $restaurant->nama . ' Kurang!, Silahkan pilih yang lain']);
                }

                // Process the selected package
                // ... (your existing code to process the selected package)
            }
            
            $data['other_setting'] = OtherSetting::get()->first();
            $other_setting = OtherSetting::get();
            $request->request->add(['qty' => $request->qty]);
            // dd($request->all());
            $price = 1;
            $user = User::where('username', $request->nama_user)->first();
    
            $today = Carbon::today();
            $formattedDate = $today->format('ymd');
    
            $lastOrder = Order::whereDate('created_at',$today)->orderBy('id','desc')->first();
            if ($lastOrder) {
                // Cek apakah order dibuat pada tanggal yang sama dengan hari ini
                $lastInvoiceNumber = $lastOrder->invoice_no;
                $lastOrderNumber = (int)substr($lastInvoiceNumber, 7);
                $nextOrderNumber = $lastOrderNumber + 1;
                // dd($nextOrderNumber);
            } else {
                $nextOrderNumber = 1;
            }
    
            $paddedOrderNumber = str_pad($nextOrderNumber, 3, '0', STR_PAD_LEFT);
            $invoiceNumber = $formattedDate . '-' . $paddedOrderNumber;
    
            if (!$user) {
                $user = new User();
                $user->username = $request->nama_user;
                $user->telephone = $request->phone;
                $user->membership_id = 1;
                $user->password = Hash::make($request->phone);
                $user->save();
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
                
                
                
                $member = Membership::get();
                $time_to = date('Y-m-d', strtotime($request->date)) . ' ' . date('H:i', strtotime($request->time_from . ' + ' . $request->jam . ' hours - 2 minutes'));
                $time_from = date('Y-m-d', strtotime($request->date)) . ' ' . date('H:i', strtotime($request->time_from));
    
                // Harga
                $harga = $request->total_paket;
                $layanan = (($request->total_paket ?? 0) * $other_setting[0]->layanan/100);
                $pb01 = ($harga + $layanan) * ($other_setting[0]->pb01 / 100);
                $total_harga = $harga + $layanan + $pb01;
    
                // Passing Harga
                $data['harga'] = $harga;
                $data['layanan'] = $layanan;
                $data['pb01'] = $pb01;
                $data['total_harga'] = $total_harga;
    
                $nama = $request->nama_user;
                $phone = $request->phone;
              
                $order = Order::create([
                    'user_id' => auth()->guest(),
                    'name' => $nama,
                    'phone' => $request->phone ?? null,
                    'qty' => $request->quantity,
                    'code' => 'draft',
                    'date' => $request->date,
                    'category' => $request->category,
                    'time_from' => $time_from,
                    'time_to' => $time_to,
                    'biliard_id' => $request->billiard_id,
                    'meeting_room_id' => $request->meeting_room_id,
                    'token' => $token,
                    'meja_restaurant_id' => $request->meja_restaurant_id,
                    // 'total_price' => \Cart::getTotal() *11/100 + \Cart::getTotal() + $biaya_layanan, 
                    // 'total_price' =>  \Cart::getTotal(), 
                    // 'total_price' => $request->total_paket + ($request->total_paket *10/100) + $biaya_layanan, 
                    'total_price' => $total_harga, 
                    // 'total_price' => 1, 
                    'status_pembayaran' => 'Unpaid',
                    'status_pesanan' => 'process',
                    'tipe_pemesanan' => $request->tipe_pemesanan,
                    'status_lamp' => 'OFF',
                    'status_running' => 'NOT START',
                    'invoice_no' => 'draft',
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
                
                // if ($request->paket_restaurant_id) {
                    $orderBilliard = [];
                    $orderBiliardIDTemp = [];
                    foreach ($request->paket_restaurant_id as $key => $value) {
                        $restaurant = Restaurant::find($value);
                        if ($restaurant) {
                            $category = $restaurant->category;
                            // $orderBilliard[] = [
                            //     'order_id' => $order->id,
                            //     'restaurant_id' => $value,
                            //     'category' => $category,
                            //     'paket_menu_id' => $request->paket_menu_id[0],
                            //     'qty' => $request->quantity, // Use $key to access the corresponding quantity
                            //     'time_from' => $time_from,
                            //     'time_to' => $time_to,
                            // ];
                            $orderBilliard = new OrderBilliard;
                            $orderBilliard->order_id = $order->id;
                            $orderBilliard->restaurant_id = $value;
                            $orderBilliard->category = $category;
                            $orderBilliard->paket_menu_id = $request->paket_menu_id[0];
                            $orderBilliard->qty = $request->quantity;
                            $orderBilliard->time_from = $time_from;
                            $orderBilliard->time_to = $time_to;
                            $orderBilliard->save();
                            $orderBiliardIDTemp[] = $orderBilliard->id;
                        }

                        // $orderBilliard = OrderBilliard::insert($orderBilliard);
                    }
                    
                    // dd($orderBilliard);
                    // $orderBilliard = DB::getPdo()->lastInsertId();
                    // }
                    
                    // dd($request->all());
                    // $orderBilliardId = DB::getPdo()->lastInsertId();
                    // foreach ($orderBiliardIDTemp as $key => $value) {
                    //     dd($value, $key);
                    // }
                    // dd($request->all(), 'masuk 1', $orderBiliardIDTemp);
                    // $orderBilliardId = $orderBiliardIDTemp[0];
                if ($request->paket_restaurant_id) {
                    foreach ($orderBiliardIDTemp as $key => $billiarID) {
                        $keyNo = $key + 1;
                        // dd($request->{'harga_addmenu_' . $keyNo}, $request->all());
                        $orderAddOn = []; // Initialize the $orderAddOn array
                        if ($request->{'harga_addmenu_' . $keyNo}) {
                            foreach ($request->{'harga_addmenu_' . $keyNo} as $key => $addOns) {
                                $addOnsData = AddOnDetail::where('id', $addOns)->first();
                                // dd($addOns, $addOnsData);
                                $orderAddOn[] = [
                                    'order_billiard_id' => $billiarID,
                                    'add_on_id' => $addOnsData->add_on_id,
                                    'add_on_detail_id' => $addOnsData->id,
                                ];
                            }
                            OrderAddOn::insert($orderAddOn);
                        }
                    }
                    // foreach ($request->paket_restaurant_id as $key => $value) {
                        // $orderAddOn = []; // Initialize the $orderAddOn array
                        // foreach ($request->harga_addmenu_1 as $key => $addOns) {
                        //     $addOnsData = AddOn::where('id', $addOns)->first();
                        //     $orderAddOn[] = [
                        //         'order_billiard_id' => $orderBilliardId,
                        //         'add_on_id' => $addOnsData->add_on_id,
                        //         'add_on_detail_id' => $addOnsData->id,
                        //     ];
                        // }
                        // // OrderAddOn::insert($orderAddOn);
                        
                        // $orderAddOn2 = []; // Initialize the $orderAddOn array
                        // foreach ($request->harga_addmenu_2 as $key => $addOns2) {
                        //     $addOnsData2 = AddOn::where('id', $addOns2)->first();
                        //     $orderAddOn2[] = [
                        //         'order_billiard_id' => $orderBilliardId,
                        //         'add_on_id' => $addOnsData2->add_on_id,
                        //         'add_on_detail_id' => $addOnsData2->id,
                        //     ];
                        // }

                        // dd($orderAddOn, $orderAddOn2);
                        // OrderAddOn::insert($orderAddOn2);
                    // }
                    // foreach ($request->harga_addmenu_1 as $groupIdentifier => $selectedItemID) {
                        
                    //     $dataaddondetail = AddOnDetail::where('id', $selectedItemID)->first();
                    //     $dataaddon = AddOn::where('id', $addOnID)->first();
                
                    //     $orderAddOn[] = [
                    //         'order_billiard_id' => $orderBilliardId,
                    //         // 'add_on_id' => $dataaddon->id,
                    //         'add_on_detail_id' => $selectedItemID,
                    //         // 'add_on_detail_id' => $request->harga_addmenu_2,
                    //     ];
                    // }
                
                    // OrderAddOn::insert($orderAddOn);
                }
                
    
                // $orderPivotId = DB::getPdo()->lastInsertId();
    
                //         if (is_iterable($item->attributes['harga_add']) && is_iterable($item->attributes['add_on_title'])) {
                //             $orderAddOn = []; // Initialize the $orderAddOn array
                //             foreach ($item->attributes['detail_addon_id'] as $innerKey => $detailAddonID) {
                //                 // $detailcheck
                //                 $detailAddonId = $item->attributes['detail_addon_id'][$innerKey];
                //                 $dataaddondetail = AddOnDetail::where('id', $detailAddonId)->first();
                //                 $dataaddon = AddOn::where('id', $dataaddondetail->add_on_id)->first();
                //                 $orderAddOn[] = [
                //                     'order_pivot_id' => $orderPivotId,
                //                     'add_on_id' => $dataaddon->id,
                //                     'add_on_detail_id' => $detailAddonId,
                //                 ];
                //             }
                        
                //             OrderAddOn::insert($orderAddOn);
                //         }
    
                $checkToken2 = Order::where('token',$token)->get();
                $data['token'] = $checkToken2->pluck('token');
    
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
                        // 'gross_amount' => $order->total_price,
                        // 'gross_amount' => str_replace(',','',number_format($order->total_price, 0)),
                        // 'gross_amount' => 1,
                        'gross_amount' => $total_harga,
                    ),
                    'customer_details' => array(
                        'first_name' => $request->name,
                        'phone' => $request->phone,
                        // 'code' => rand(),
                    ),
                );
    
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            // dd($snapToken);
            $data['data_carts'] = \Cart::session(Auth::guest())->getContent();
            // $data['orders'] = Order::get();
            $data['orders'] = Order::latest()->first();
            $data['order_last'] = Order::latest()->first();
            DB::commit();
            return view('checkout.billiard-index-guest',$data,compact('snapToken','order'));
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('failed', $th->getMessage());
        }

    }

    public function checkoutMeeting(Request $request){
        $request->request->add(['qty' => $request->qty]);
        $other_setting = OtherSetting::get();

        $today = Carbon::today();
        $formattedDate = $today->format('ymd');

        $lastOrder = Order::whereDate('created_at',$today)->orderBy('id','desc')->first();
        if ($lastOrder) {
            // Cek apakah order dibuat pada tanggal yang sama dengan hari ini
            $lastInvoiceNumber = $lastOrder->invoice_no;
            $lastOrderNumber = (int)substr($lastInvoiceNumber, 7);
            $nextOrderNumber = $lastOrderNumber + 1;
            // dd($nextOrderNumber);
        } else {
            $nextOrderNumber = 1;
        }

        $paddedOrderNumber = str_pad($nextOrderNumber, 3, '0', STR_PAD_LEFT);
        $invoiceNumber = $formattedDate . '-' . $paddedOrderNumber;

        // $other_setting = OtherSetting::first();

        // dd($request->request->add(['qty' => $request->qty]));
        $biaya_layanan = 5000;
        $price = 1;
        $session_cart = \Cart::session(Auth::user()->id)->getContent();

        foreach ($session_cart as $key => $value) {
            $price += $value->price;
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
            
            $restaurant = Restaurant::get();
            
            $member = Membership::get();
            $time_to = date('Y-m-d', strtotime($request->date)) . ' ' . date('H:i', strtotime($request->time_from . ' + ' . $request->jam . ' hours - 2 minutes'));
            // dd($request->all());
            $time_from = date('Y-m-d', strtotime($request->date)) . ' ' . date('H:i', strtotime($request->time_from));
            if (Auth::user()->membership->level == 'Super Platinum') {
                $order = Order::create([
                    // $request->all()
                    'user_id' => auth()->user()->id,
                    'name' => auth()->user()->username,
                    'qty' => $request->qty,
                    'code' => $invoiceNumber,
                    'date' => $request->date,
                    'category' => $request->category,
                    'time_from' => $time_from,
                    'time_to' => $time_to ,
                    'biliard_id' => $request->biliard_id,
                    'meeting_room_id' => $request->meeting_room_id,
                    // 'total_price' => \Cart::getTotal() *11/100 + \Cart::getTotal() + $biaya_layanan, 
                    // 'total_price' =>  \Cart::getTotal(), 
                    'total_price' => 0, 
                    'status_pembayaran' => 'Unpaid',
                    'status_pesanan' => 'process',
                    'tipe_pemesanan' => $request->tipe_pemesanan,
                    'invoice_no' => $invoiceNumber,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            } else {
                $biaya_layanan = 0;
                $order = Order::create([
                    // $request->all()
                    'user_id' => auth()->user()->id,
                    'name' => auth()->user()->username,
                    'qty' => $request->qty,
                    'code' => $invoiceNumber,
                    'date' => $request->date,
                    'category' => $request->category,
                    'time_from' => $time_from,
                    'time_to' => $time_to,
                    'biliard_id' => $request->biliard_id,
                    'meeting_room_id' => $request->meeting_room_id,
                    'meja_restaurant_id' => $request->meja_restaurant_id,
                    // 'total_price' => \Cart::getTotal() *11/100 + \Cart::getTotal() + $biaya_layanan, 
                    // 'total_price' =>  \Cart::getTotal(), 
                    // 'total_price' => $request->total_paket + ($request->total_paket *10/100) + $biaya_layanan, 
                    'total_price' =>(\Cart::getTotal() + ((\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100)) + ((\Cart::getTotal()  ?? '0') + (\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100) * $other_setting[0]->pb01/100, 
                    'status_pembayaran' => 'Unpaid',
                    'status_pesanan' => 'process',
                    'tipe_pemesanan' => $request->tipe_pemesanan,
                    'invoice_no' => $invoiceNumber,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);

                // foreach ($session_cart as $key => $item) {
                //     $paketRestaurantIds = $item->attributes->paket_restaurant_id;
                //     $paketRestoCategory = $item->attributes->category;
                        
                //     $length = min(count($paketRestaurantIds), count($paketRestoCategory));
                    
                //     for ($i = 0; $i < $length; $i++) {
                //         $paketRestaurantId = $paketRestaurantIds[$i];
                //         $category = $paketRestoCategory[$i];
                    
                //         $orderMeeting[] = [
                //             'order_id' => $order->id,
                //             'restaurant_id' => $paketRestaurantId,
                //             'paket_menu_id' => $item->id,
                //             'category' => $category,
                //             'qty' => $item->quantity,
                //             'time_from' => $time_from,
                //             'time_to' => $time_to,
                //         ];
                //     }
                    
                //     OrderMeetingRoom::insert($orderMeeting);
                // }

                // if ($request->paket_restaurant_id) {
                //     $orderMeeting = [];
                //     foreach ($request->paket_restaurant_id as $key => $value) {
                //         $orderMeeting[] = [
                //             'order_id' => $order->id,
                //             'restaurant_id' => $value,
                //             'paket_menu_id' => isset($request->meeting_room_id[$key]) ? $request->meeting_room_id[$key] : null,
                //             'category' => isset($request->category_paket[$key]) ? $request->category_paket[$key] : null,
                //             'qty' => $request->quantity,
                //             'time_from' => $time_from,
                //             'time_to' => $time_to,
                //         ];
                //     }
                //     OrderMeetingRoom::insert($orderMeeting);
                // }

                if ($request->paket_restaurant_id) {
                    $orderMeeting = [];
                
                    foreach ($request->paket_restaurant_id as $key => $value) {
                        $orderMeeting[] = [
                            'order_id' => $order->id,
                            'restaurant_id' => $value, // Access the individual value using $value
                            'category' => $request->category_paket[$key], // Access the corresponding category using $key
                            'qty' => $request->quantity, // Access the corresponding quantity using $key
                            'time_from' => $time_from,
                            'time_to' => $time_to,
                        ];
                    }
                
                    OrderMeetingRoom::insert($orderMeeting);
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
                    'gross_amount' => $order->total_price,
                    // 'gross_amount' => 1,
                ),
                'customer_details' => array(
                    'first_name' => auth()->user()->username,
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
                    // 'gross_amount' => 1,
                ),
                'customer_details' => array(
                    'first_name' => auth()->user()->username,
                    'phone' => $request->telephone,
                    // 'code' => rand(),
                ),
            );
            // dd($params);
            # code...
        }


        $snapToken = \Midtrans\Snap::getSnapToken($params);
        // dd($snapToken);
        $data['data_carts'] = \Cart::session(Auth::user()->id)->getContent();
        // $data['orders'] = Order::get();
        // $data['orders'] = Order::latest()->first();
        $data['order_last'] = Order::latest()->first();
        return view('checkout.meeting-index',$data,compact('snapToken','order'));
    }

    public function invoice($id)
    {
        // dd('tes');
        $order = Order::find($id);
        return view('checkout.invoice',compact('order'));
    }

    public function successOrder(Request $request){

        try {
            $order = Order::find($request->data['order_id']);

            if ($order->meja_restaurant_id != null || $order->category == 'Takeaway') {
                $userID = $order->user_id;
                
                if (auth()->guest() == true) {
                    $userUpdate = auth()->guest() ? 'guest' : auth()->user()->id;
                    $cart = \Cart::session($userUpdate)->getContent();

                    foreach ($cart as $item) {
                        \Cart::session($userUpdate)->remove($item->id);
                    }

                    foreach ($cart as $key => $item) {
                        $restoStock = Restaurant::where('id', $item->attributes['restaurant']['id'])->first();
                        $stockAvailable = ($restoStock->current_stok - $item->quantity);
                        
                        // Memperbarui stok restoran
                        $restoStock->update(['current_stok' => $stockAvailable,]);

                }
                }else{
                    $cart = \Cart::session($userID)->getContent();
                    
                    // Menghapus item dari session cart
                    foreach ($cart as $item) {
                        \Cart::session($userID)->remove($item->id);
                    }
            
                    foreach ($cart as $key => $item) {
                        $restoStock = Restaurant::where('id', $item->attributes['restaurant']['id'])->first();
                        $stockAvailable = ($restoStock->current_stok - $item->quantity);
                        
                        // Memperbarui stok restoran
                        $restoStock->update(['current_stok' => $stockAvailable]);
                    }


                }
            }else if($order->billiard_id != null){
                $orderBilliard = OrderBilliard::where('order_id',$order->id)->get();
                foreach ($orderBilliard as $key => $item) {
                    $restoStock = Restaurant::where('id', $orderBilliard->restaurant_id)->first();
                    $stockAvailable = ($restoStock->current_stok - $item->quantity);
                    
                    // Memperbarui stok restoran
                    $restoStock->update(['current_stok' => $stockAvailable]);
                }
            }
    
            $responseData = [
                'code' => 200,
                'updateStock' => true,
                'deleteCart' => true,
            ];
    
            return $responseData;
        } catch (\Throwable $th) {
            $responseData = [
                'code' => 500,
                'updateStock' => false,
                'deleteCart' => false,
                'message' => $th->getMessage(),
            ];
            return $responseData;
        }
        // return $request;
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

    public function feedback(Request $request, $token, $id) {

        try {
            $getDataFeedback = $request->feedback;
            $getDataFeedbackdescription = $request->description_feedback;
            $getID = Crypt::decryptString($id);
            $getID = explode('-',$getID);
            $getID = $getID[1];
            $getToken = Crypt::decryptString($token);
            $getToken = explode('-',$getToken);
            $getToken = (int)$getToken[1];

            if (!$getID && !$getDataFeedback && !$getToken) {
                return redirect()->route('homepage')->with(['failed' => 'Send feedback failed!', 'auth' => Auth::user()->id, 'menu' => 'feedback']);
            }

            Order::where("id", $getID)->update(["status_feedback" => true, "feedback"  => $getDataFeedback, "description_feedback" => $getDataFeedbackdescription]);

            return redirect()->route('homepage')->with(['success' => 'Send feedback successfully! Thankyou...', 'auth' => $getToken, 'menu' => 'feedback']);
        } catch (\Throwable $th) {
            return redirect()->route('homepage')->with(['failed' => 'Send feedback failed! ' . $th->getMessage(), 'auth' => $getToken, 'menu' => 'feedback']);
        }
    }

    private function generateInvoice()
    {
        
        $today = Carbon::today();
        $formattedDate = $today->format('ymd');

        $lastOrder = Order::whereDate('updated_at', $today)->where('status_pembayaran', 'Paid')->orderBy('id','desc')->first();
        if ($lastOrder) {
            // Cek apakah order dibuat pada tanggal yang sama dengan hari ini
            $lastInvoiceNumber = $lastOrder->invoice_no;
            $lastOrderNumber = (int)substr($lastInvoiceNumber, 7);
            $nextOrderNumber = $lastOrderNumber + 1;
            // dd($nextOrderNumber);
        } else {
            $nextOrderNumber = 1;
        }

        $paddedOrderNumber = str_pad($nextOrderNumber, 3, '0', STR_PAD_LEFT);
        $invoiceNumber = $formattedDate . '-' . $paddedOrderNumber;

        return $invoiceNumber;
    }

    
}
