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
use Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Xendit\Xendit;
use Illuminate\Support\Facades\DB;
// require 'vendor/autoload.php';
class OrderController extends Controller
{
    public function index()
    {

        return view('checkout.order');
    }
    public function resetMeja(){
        try {
            // Dapatkan user yang sedang login
            $user = Auth::user();

            if (!$user) {
                // User tidak ditemukan, berikan tanggapan sesuai kebutuhan
                return redirect()->back()->with('error', 'User tidak ditemukan.');
            }

            // Hapus data meja_restaurant_id pada user
            // dd($user->kode_meja);
            $user->kode_meja = null;
            // $user->is_worker = false;
            $user->save();

            // Redirect ke halaman yang sesuai dengan kebutuhan Anda
            return redirect()->back()->with('success', 'Data meja berhasil dihapus dari user.');
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi
            return redirect()->back()->with('failed', 'Terjadi kesalahan saat menghapus data meja.');
        }
    }

    public function checkoutWaiters(Request $request){
        $latestOrder = Order::latest()->first();

        if ($latestOrder) {
            // Ubah status pembayaran menjadi "Paid"
            $latestOrder->update(['status_pembayaran' => 'Paid']);
            $userID = $latestOrder->user_id;
            $cart = \Cart::session($userID)->getContent();

             // Menghapus item dari session cart
             foreach ($cart as $item) {
                \Cart::session($userID)->remove($item->id);
            }

            foreach ($cart as $key => $item) {
                $restoStock = Restaurant::where('id', $key)->first();
                $stockAvailable = ($restoStock->current_stok - $item->quantity);
                
                // Memperbarui stok restoran
                $restoStock->update(['current_stok' => $stockAvailable]);
            }

        }

        return redirect()->route('homepage')->with('success', 'Order Telah berhasil');

    }

    public function checkout(Request $request)
    {
        $request->request->add(['qty' => $request->qty]);
        // dd($request->request->all());
        $biaya_layanan = 5000;
        $price = 1;
        $session_cart = \Cart::session(Auth::user()->id)->getContent();

        // $user = User::where('membership_id', 1)->get();
        // foreach ($user as $key => $value) {
        //     // dd($value);
        //     # code...
        //     if ($value == true) {
        //         dd('berhasil');
        //     }else{
        //         dd('gagal');
        //     }
        // }
        // foreach ($session_cart as $key => $item) {
        //     $restoStock = Restaurant::where('id',$key)->get()->first();
        //     $stockAvailable = ($restoStock->current_stok - $item->quantity);
        //     $restoStock->update(['current_stok' => $stockAvailable]);
        // }

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

        $restaurant = Restaurant::get();
        $orderDetail = OrderPivot::get();
        $orders = Order::where('status_pembayaran', 'Paid')->get();
        
        $member = Membership::get();
        $other_setting = OtherSetting::get();

        // foreach ($session_cart as $key => $item) {
        //     $restoStock = Restaurant::where('id',$key)->get()->first();
        //     $stockAvailable = ($restoStock->current_stok - $item->quantity);
        //     // dd($stockAvailable);
        //     $restoStock->update(['current_stok' => $stockAvailable]);
        // }

        $countQty = [];
        // foreach ($restaurant as $res) {
        //     $countQty = $restaurant->map(function ($res) use ($orderDetail, $orders) {
        //         $count = $orderDetail->where('restaurant_id', $res->id)
        //             ->whereIn('order_id', $orders->pluck('id')->toArray())
        //             ->sum('qty');
        //         return [
        //             'restaurant_id' => $res->id,
        //             'count' => $count,
        //         ];
        //     })->pluck('count', 'restaurant_id')->toArray();
        //     // $countQty[$res->id] = $count;
        // }
        foreach ($restaurant as $res) {
            $countQty = $restaurant->map(function ($res) use ($orderDetail, $orders) {
                $count = $orderDetail->where('restaurant_id', $res->id)
                    ->whereIn('order_id', $orders->pluck('id')->toArray())
                    ->sum('qty');
                return [
                    'restaurant_id' => $res->id,
                    'count' => $count,
                ];
            })->pluck('count', 'restaurant_id')->toArray();
            
        }
        // dd($countQty);
        foreach ($session_cart as $key => $item) {
            $checkCount = Restaurant::where('id', $key)->get()->map(function ($resto) use ($item, $key) {
                $count = $resto->where('id', $key)->pluck('current_stok');
                // dd((int)$count[0] , $item->quantity);
                return (int)$count[0] <= $item->quantity;

            });

            if ($checkCount[0] == true) {
                return redirect()->route('cart')->with(['failed' => 'Stok' . $item->name .' Kurang !']);

                // return redirect()->route('cart')->with('message', 'Stok '. $item->name .' Kurang !');
            }
        }
            // $time_to = date('Y-m-d', strtotime($request->date)) . ' ' . date('H:i', strtotime($request->time_from . ' + ' . $request->jam . ' hours'));
            $time_to = date('Y-m-d', strtotime($request->date)) . ' ' . date('H:i', strtotime($request->time_from . ' + ' . $request->jam . ' hours - 2 minutes'));
            // dd($request->all());
            $time_from = date('Y-m-d', strtotime($request->date)) . ' ' . date('H:i', strtotime($request->time_from));

            if (Auth::user()->membership->level == 'Super Platinum') {
                $order = Order::create([
                    'user_id' => auth()->user()->id,
                    'name' => auth()->user()->username,
                    'qty' => $request->qty,
                    'code' => $newInvoiceNumber,
                    'date' => $request->date,
                    'category' => $request->category,
                    'time_from' => $time_from,
                    'time_to' => $time_to,
                    'biliard_id' => $request->biliard_id,
                    'meeting_room_id' => $request->meeting_room_id,
                    'meja_restaurant_id' => $request->meja_restaurant_id,
                    // 'total_price' => \Cart::getTotal() *11/100 + \Cart::getTotal() + $biaya_layanan, 
                    // 'total_price' =>  \Cart::getTotal(), 
                    // 'total_price' => \Cart::getTotal() + $biaya_layanan, 
                    'total_price' => 1, 
                    'status_pembayaran' => 'Unpaid',
                    'status_pesanan' => 'process',
                    'tipe_pemesanan' => $request->tipe_pemesanan,
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
                    'category' => $request->category,
                    'time_from' => $time_from,
                    'time_to' => $time_to,
                    'biliard_id' => $request->biliard_id,
                    'meeting_room_id' => $request->meeting_room_id,
                    'meja_restaurant_id' => $request->meja_restaurant_id,
                    // 'total_price' => \Cart::getTotal() *$other_setting[0]->pb01/100 + \Cart::getTotal() + $other_setting[0]->layanan, 
                    // 'total_price' =>  \Cart::getTotal(), 
                    // 'total_price' => \Cart::getTotal() + $biaya_layanan, 
                    // 'total_price' => 1, 
                    'total_price' =>(\Cart::getTotal() + ((\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100)) + ((\Cart::getTotal()  ?? '0') + (\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100) * $other_setting[0]->pb01/100, 
                    
                    'status_pembayaran' => 'Unpaid',
                    'status_pesanan' => 'process',
                    'tipe_pemesanan' => $request->tipe_pemesanan,
                    'invoice_no' => $newInvoiceNumber,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);

                foreach ($session_cart as $key => $item) {
                    // dd($item->attributes);
                    $orderPivot = [];
                    if ($item->conditions == 'Restaurant') {
                        $orderPivot[] = [
                            'order_id' => $order->id,
                            'restaurant_id' => $item->associatedModel->id,
                            // 'paket_menu_id' => $item->id,
                            'category' => $item->model->category,
                            'qty' => $item->quantity,
                        ];
                        OrderPivot::insert($orderPivot);

                        $orderPivotId = DB::getPdo()->lastInsertId();

                        // $orderAddOn = [];
                        // if (is_iterable($item->attributes->harga_add)) {
                        //     foreach ($item->attributes->harga_add as $addOnId) {
                        //         $dataAddonTitle = AddOnDetail::where('id', $addOnId)->get()->pluck('add_on_id')->first();

                        //         dd($dataAddonTitle);    
                        //         $orderAddOn[] = [
                        //             'order_pivot_id' => $orderPivotId,
                        //             'add_on_id' => $dataAddonTitle,
                        //             'add_on_detail_id' => $addOnId,
                        //         ];
                        //     }
                        //     OrderAddOn::insert($orderAddOn);
                        // }

                        // $orderAddOn = [];

                        if (is_iterable($item->attributes->harga_add) && is_iterable($item->attributes->add_on_title)) {
                            $orderAddOn = []; // Initialize the $orderAddOn array
                            foreach ($item->attributes->detail_addon_id as $innerKey => $detailAddonID) {
                                // $detailcheck
                                $detailAddonId = $item->attributes->detail_addon_id[$innerKey];
                                $dataaddondetail = AddOnDetail::where('id', $detailAddonId)->first();
                                $dataaddon = AddOn::where('id', $dataaddondetail->add_on_id)->first();
                                $orderAddOn[] = [
                                    'order_pivot_id' => $orderPivotId,
                                    'add_on_id' => $dataaddon->id,
                                    'add_on_detail_id' => $detailAddonId,
                                ];
                            }
                        
                            OrderAddOn::insert($orderAddOn);
                        }
                        




                    }elseif ($item->conditions == 'Paket Menu') {
                        # code...
                        $paketRestaurantIds = $item->attributes->paket_restaurant_id;
                        $paketRestoCategory = $item->attributes->category;
                        
                        $length = min(count($paketRestaurantIds), count($paketRestoCategory));
                        
                        for ($i = 0; $i < $length; $i++) {
                            $paketRestaurantId = $paketRestaurantIds[$i];
                            $category = $paketRestoCategory[$i];
                        
                            $orderBilliard[] = [
                                'order_id' => $order->id,
                                'restaurant_id' => $paketRestaurantId,
                                'paket_menu_id' => $item->id,
                                'category' => $category,
                                'qty' => $item->quantity,
                                'time_from' => $time_from,
                                'time_to' => $time_to,
                            ];
                        }
                        OrderBilliard::insert($orderBilliard);
                    } else{
                        $paketRestaurantIds = $item->attributes->paket_restaurant_id;
                        $paketRestoCategory = $item->attributes->category;
                        
                        $length = min(count($paketRestaurantIds), count($paketRestoCategory));
                        
                        for ($i = 0; $i < $length; $i++) {
                            $paketRestaurantId = $paketRestaurantIds[$i];
                            $category = $paketRestoCategory[$i];
                        
                            $orderMeeting[] = [
                                'order_id' => $order->id,
                                'restaurant_id' => $paketRestaurantId,
                                'paket_menu_id' => $item->id,
                                'category' => $category,
                                'qty' => $item->quantity,
                                'time_from' => $time_from,
                                'time_to' => $time_to,
                            ];
                        }
                        
                        OrderMeetingRoom::insert($orderMeeting);
                        
                    }
                    // OrderPivot::insert($orderPivot);
                    
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
                    // 'gross_amount' => 1,
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
        // $data['orders'] = Order::get();
        $data['order_last'] = Order::latest()->first();

        // foreach ($order_latest as $key => $value) {
        //     $data['order_last'] = $value; 
        // }

        $data['order_settings'] = OtherSetting::get();
        return view('checkout.index',$data,compact('snapToken','order'));
    }

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
                $order->update(['status_pembayaran' => 'Paid']);
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
                $user_member = User::where('membership_id',1)->get();

                foreach ($user_member as $key => $value) {
                    if ($value) {
                        $user->membership_id = 1;
                        $user->save();
                    }else{
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

    public function checkoutBilliard(Request $request){
        $data['order_settings'] = OtherSetting::get();
        $other_setting = OtherSetting::get();

        $request->request->add(['qty' => $request->qty]);
        // dd($request->all());
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
                    'code' => $newInvoiceNumber,
                    'date' => $request->date,
                    'category' => $request->category,
                    'time_from' => $time_from,
                    'time_to' => $time_to ,
                    'biliard_id' => $request->billiard_id,
                    'meeting_room_id' => $request->meeting_room_id,
                    // 'total_price' => \Cart::getTotal() *11/100 + \Cart::getTotal() + $biaya_layanan, 
                    // 'total_price' =>  \Cart::getTotal(), 
                    'total_price' => 1, 
                    'status_pembayaran' => 'Unpaid',
                    'status_pesanan' => 'process',
                    'tipe_pemesanan' => $request->tipe_pemesanan,
                    'status_lamp' => 'OFF',
                    'status_running' => 'NOT START',
                    'invoice_no' => $newInvoiceNumber,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            } else {
                $biaya_layanan = 0;
                $order = Order::create([
                    // $request->all()
                    'user_id' => auth()->user()->id,
                    'name' => auth()->user()->username,
                    'qty' => $request->quantity,
                    'code' => $newInvoiceNumber,
                    'date' => $request->date,
                    'category' => $request->category,
                    'time_from' => $time_from,
                    'time_to' => $time_to,
                    'biliard_id' => $request->billiard_id,
                    'meeting_room_id' => $request->meeting_room_id,
                    'meja_restaurant_id' => $request->meja_restaurant_id,
                    // 'total_price' => \Cart::getTotal() *11/100 + \Cart::getTotal() + $biaya_layanan, 
                    // 'total_price' =>  \Cart::getTotal(), 
                    // 'total_price' => $request->total_paket + ($request->total_paket *10/100) + $biaya_layanan, 
                    'total_price' =>(\Cart::getTotal() + ((\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100)) + ((\Cart::getTotal()  ?? '0') + (\Cart::getTotal() ?? '0') * $other_setting[0]->layanan/100) * $other_setting[0]->pb01/100, 
                    'status_pembayaran' => 'Unpaid',
                    'status_pesanan' => 'process',
                    'tipe_pemesanan' => $request->tipe_pemesanan,
                    'status_lamp' => 'OFF',
                    'status_running' => 'NOT START',
                    'invoice_no' => $newInvoiceNumber,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);

                // foreach ($session_cart as $key => $item) {
                //     // dd($item->attributes->category);
                //     $orderPivot = [];
                //     if ($item->conditions == 'Restaurant') {
                //         $orderPivot[] = [
                //             'order_id' => $order->id,
                //             'restaurant_id' => $item->associatedModel->id,
                //             // 'paket_menu_id' => $item->id,
                //             'category' => $item->model->category,
                //             'qty' => $item->quantity,
                //         ];
                //     }elseif ($item->conditions == 'Paket Menu') {
                //         # code...
                //         $paketRestaurantIds = $item->attributes->paket_restaurant_id;
                //         $paketRestoCategory = $item->attributes->category;
                        
                //         $length = min(count($paketRestaurantIds), count($paketRestoCategory));
                        
                //         for ($i = 0; $i < $length; $i++) {
                //             $paketRestaurantId = $paketRestaurantIds[$i];
                //             $category = $paketRestoCategory[$i];
                        
                //             $orderBilliard[] = [
                //                 'order_id' => $order->id,
                //                 'restaurant_id' => $paketRestaurantId,
                //                 'paket_menu_id' => $item->id,
                //                 'category' => $category,
                //                 'qty' => $item->quantity,
                //                 'time_from' => $time_from,
                //                 'time_to' => $time_to,
                //             ];
                //         }
                //         OrderBilliard::insert($orderBilliard);
                //     } else{
                //         $paketRestaurantIds = $item->attributes->paket_restaurant_id;
                //         $paketRestoCategory = $item->attributes->category;
                        
                //         $length = min(count($paketRestaurantIds), count($paketRestoCategory));
                        
                //         for ($i = 0; $i < $length; $i++) {
                //             $paketRestaurantId = $paketRestaurantIds[$i];
                //             $category = $paketRestoCategory[$i];
                        
                //             $orderMeeting[] = [
                //                 'order_id' => $order->id,
                //                 'restaurant_id' => $paketRestaurantId,
                //                 'paket_menu_id' => $item->id,
                //                 'category' => $category,
                //                 'qty' => $item->quantity,
                //                 'time_from' => $time_from,
                //                 'time_to' => $time_to,
                //             ];
                //         }
                        
                //         OrderMeetingRoom::insert($orderMeeting);
                        
                //     }
                //     OrderPivot::insert($orderPivot);

                if ($request->paket_restaurant_id) {
                    $orderBilliard = [];
                
                    foreach ($request->paket_restaurant_id as $key => $value) {
                        $orderBilliard[] = [
                            'order_id' => $order->id,
                            'restaurant_id' => $value, // Access the individual value using $value
                            'category' => $request->category_paket[$key], // Access the corresponding category using $key
                            'qty' => $request->quantity, // Access the corresponding quantity using $key
                            'time_from' => $time_from,
                            'time_to' => $time_to,
                        ];
                    }
                
                    OrderBilliard::insert($orderBilliard);
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
                    // 'gross_amount' => 1,
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
        // $data['orders'] = Order::get();
        $data['orders'] = Order::latest()->first();
        $data['order_last'] = Order::latest()->first();
        return view('checkout.billiard-index',$data,compact('snapToken','order'));
    }

    public function checkoutMeeting(Request $request){
        $request->request->add(['qty' => $request->qty]);
        $other_setting = OtherSetting::get();

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
                    'code' => $newInvoiceNumber,
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
                    'invoice_no' => $newInvoiceNumber,
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

            if ($order->meja_restaurant_id != null) {
                $userID = $order->user_id;
                $cart = \Cart::session($userID)->getContent();
                
                // Menghapus item dari session cart
                foreach ($cart as $item) {
                    \Cart::session($userID)->remove($item->id);
                }
        
                foreach ($cart as $key => $item) {
                    $restoStock = Restaurant::where('id', $key)->first();
                    $stockAvailable = ($restoStock->current_stok - $item->quantity);
                    
                    // Memperbarui stok restoran
                    $restoStock->update(['current_stok' => $stockAvailable]);
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
}
