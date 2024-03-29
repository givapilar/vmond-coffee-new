<?php

namespace App\Http\Controllers;

use App\Models\AddOn;
use App\Models\AddOnDetail;
use App\Models\Biliard;
use App\Models\CartOrders;
use App\Models\MeetingRoom;
use App\Models\MejaRestaurant;
use App\Models\MenuPackages;
use App\Models\OrderPivot;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\OtherSetting;
use App\Models\Role;
use App\Models\UserManagement;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
// use Gloudemans\Shoppingcart\facades\Cart;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
// use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Cart;

class CartOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data ['meja_restaurants'] = MejaRestaurant::get();
        $data['meja_restaurants'] = MejaRestaurant::orderby('id', 'asc')->get();

        $rest_api_url = 'https://managementvmond.controlindo.com/api/v1/vmond/user/get-role';

        $getData = file_get_contents($rest_api_url);
        try {
            $role = json_decode($getData);
            // dd($role);
            // $data = $data->data;
        } catch (\Throwable $th) {
            $role = [];
        }


        $data ['userManagement'] = UserManagement::orderby('id', 'asc')->get();
        $data ['order_settings'] = OtherSetting::get();
        $data['vouchers'] = Voucher::get();

        if (Auth::check()) {
            # code...
            $data['data_carts'] = \Cart::session(Auth::user()->id)->getContent();
        }else{
            $user = 'guest';
            $data['cart_guest'] = \Cart::session($user)->getContent();
        }
        // dd($data['data_carts'][0]['attributes']);
        $processedCartItems = [];

        if (Auth::check()) {
            foreach ($data['data_carts'] as $cartItem) {
                // Access individual cart item properties
                $id = $cartItem->id;
                $name = $cartItem->name;
                $price = $cartItem->price;
                $quantity = $cartItem->quantity;
                $conditions = $cartItem->conditions;

                $cartItemData = [
                    'id' => $id,
                    'name' => $name,
                    'price' => $price,
                    'quantity' => $quantity,
                    'conditions' => $conditions,
                    // ... and so on
                ];
                // tanda
                // Store the cart item data in the $processedCartItems array
                // $processedCartItems[] = $cartItemData;
                // $data['processedCartItems'] = $processedCartItems;
                
            }
            return view('cart.index',$data,compact(['role']));    
        }else{
            foreach ($data['cart_guest'] as $cartItem) {
                // Access individual cart item properties
                $id = $cartItem->id;
                $name = $cartItem->name;
                $price = $cartItem->price;
                $quantity = $cartItem->quantity;
                $conditions = $cartItem->conditions;

                $cartItemData = [
                    'id' => $id,
                    'name' => $name,
                    'price' => $price,
                    'quantity' => $quantity,
                    'conditions' => $conditions,
                    // ... and so on
                ];

                // $processedCartItems[] = $cartItemData;
                // $data['processedCartItems'] = $processedCartItems;
            }

            // $data1 = "00020101021226620017ID.CO.BANKBJB.WWW01189360011030001393800208001393800303UMI51470017ID.CO.BANKBJB.WWW0215ID12312312938560303UMI5204581253033605405200005802ID5912Vmond Coffee6007Bandung61051232262510124QRIS2023090715063500717102120817171819880703C026304DD65";
        
            // // Generate QR Code
            // $data['qrCode'] = QrCode::encoding('UTF-8')
            //     ->size(400)
            //     ->margin(10)
            //     ->generate($data1);

            return view('cart.cart-guest',$data);
        }

    }

    public function addCartRestaurant(Request $request,$id)
    {
        // dd($request->all());

        // try {
            $restaurant = Restaurant::findOrFail($id);
        
        if ($restaurant->current_stok <= 0) {
            return redirect()->back()->with(['failed' => 'Stok ' . $restaurant->name . ' Kurang!']);
        }

        $currentTime = Carbon::now()->format('H:i');

        $other_setting = OtherSetting::get()->first();

        // Jam batas untuk menerima pesanan (misalnya, jam 11:00 PM)
        
        // Jam batas untuk mulai menerima pesanan lagi (misalnya, jam 7:00 AM)
        
        // Jika waktu saat ini melebihi batas pesanan, maka kembalikan pesan error
        // $currentDay = date('N'); // Mendapatkan hari dalam format 1 (Senin) hingga 7 (Minggu)
        // if ($restaurant->category == 'Minuman') {
            
        //     if ($currentDay >= 1 && $currentDay <= 4) {
        //         // Weekdays (Senin-Kamis)
        //         $orderOpenTime = $other_setting->time_start_weekdays_minuman;
        //         $orderDeadline = $other_setting->time_close_weekdays_minuman;
        //     } else if ($currentDay >= 5 && $currentDay <= 7) {
        //         // Weekend (Sabtu/Minggu)
        //         $orderOpenTime = $other_setting->time_start_weekend_minuman;
        //         $orderDeadline = $other_setting->time_close_weekend_minuman;
        //     }
            
        //     if ($currentTime > $orderDeadline) {
        //         return redirect()->back()->with(['failed' => 'Maaf, Kita Sudah Close Order']);
        //     } elseif ($currentTime < $orderOpenTime) {
        //         // Jika waktu saat ini masih sebelum batas pemesanan pagi, maka tampilkan pesan bahwa pemesanan belum dibuka
        //         return redirect()->back()->with(['failed' => 'Maaf, Cafe belum dibuka. Silakan coba lagi nanti']);
        //     }
        //     // makanan
        // }else{
        //     if ($currentDay >= 1 && $currentDay <= 4) {
        //         // Weekdays (Senin-Kamis)
        //         $orderOpenTimeMakanan = $other_setting->time_start;
        //         $orderDeadlineMakanan = $other_setting->time_close;
        //     } else if ($currentDay >= 5 && $currentDay <= 7) {
        //         // Weekend (Sabtu/Minggu)
        //         // dd('masuk');
        //         $orderOpenTimeMakanan = $other_setting->time_start_weekend;
        //         $orderDeadlineMakanan = $other_setting->time_close_weekend;
        //     }
        //     // $orderOpenTimeMakanan = $other_setting->time_start_weekend;
        //     // $orderDeadlineMakanan = $other_setting->time_close_weekend;
        //     // $orderOpenTimeMakanan = $other_setting->time_start;
        //     // $orderDeadlineMakanan = $other_setting->time_close;
        //     if ($currentTime > $orderDeadlineMakanan) {
        //         return redirect()->back()->with(['failed' => 'Maaf, Kita Sudah Close Order']);
        //     } elseif ($currentTime < $orderOpenTimeMakanan) {
        //         // Jika waktu saat ini masih sebelum batas pemesanan pagi, maka tampilkan pesan bahwa pemesanan belum dibuka
        //         return redirect()->back()->with(['failed' => 'Maaf, Cafe belum dibuka. Silakan coba lagi nanti']);
        //     }
        // }
        
        

        $dataHargaAddon = [];
        if ($request->harga_add != null) {
            foreach ($request->harga_add as $key => $val) {
                $data_addOn = AddOnDetail::where('id', $val)->get();
                $dataHargaAddon[] = $data_addOn[0]->harga . '';
            }
        }



        $countAddOn = $request->harga_add ? count($request->harga_add) : 0;

        if ((($countAddOn < $request->minimum) && $restaurant->addOns->isNotEmpty()) && $request->addOnChange != 'Normal') {
            return redirect()->back()->with(['failed' => 'Harap Pilih Add On Sesuai minimum !!']);
        }

        if ($request->quantity) {
            $quantity = $request->quantity;
        } else {
            $quantity = 0;
        }
    
        
        // dd($dataHargaAddon);
        $validator = Validator::make($request->all(), [
            'qty' => 'nullable',
            'category' => 'nullable',
            // 'add_on_title' => 'required',
            // 'harga_add' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // dd('sucess');

        if (Auth::check()) {

            // $userPhoneNumber = Auth::user()->telephone;
            // // dd($userPhoneNumber);
            // // Define an array of allowed phone numbers
            // $allowedPhoneNumbers = [
            //     '08123456001',
            //     '08123456003',
            //     '08123456004',
            //     '08123456005',
            //     '081818181847',
            // ];

            // if (in_array($userPhoneNumber, $allowedPhoneNumbers)) {
                $cartContent = \Cart::session(Auth::user()->id)->getContent();
                
                $addonDetail = array(
                    'restaurant' => $restaurant,
                    'category' => $request->category,
                    'add_on_title' => $request->add_on_title,
                    'harga_add' => $dataHargaAddon,
                    'detail_addon_id' => $request->harga_add,
                    'add_on_nama_title' => $request->add_on_nama_title,
                    'add_nama' => $request->add_nama,
                );
            
                // Mengkonversi array add-on detail menjadi JSON untuk digunakan sebagai kunci unik
                $itemIdentifier = md5(json_encode($addonDetail));
            
                // Memeriksa apakah item dengan add-on detail yang sama sudah ada di dalam Cart
                $existingItem = $cartContent->first(function ($item, $key) use ($itemIdentifier) {
                    return $item->id === $itemIdentifier;
                });
            
                if ($existingItem !== null) {
                    // Jika item dengan add-on detail yang sama sudah ada di dalam Cart
                    // Buat array baru dengan membawa detail add-on ID yang berbeda
                    $itemAttributes = $existingItem->attributes->toArray();
                    // if (!in_array($request->harga_add, $itemAttributes['detail_addon_id'])) {
                    //     $itemAttributes['detail_addon_id'] = $request->harga_add;
                    //     $existingItem->attributes = $itemAttributes;
                    //     $existingItem->quantity += $request->qty;
                    //     \Cart::session(Auth::user()->id)->update($existingItem->id, $existingItem->toArray());
                    // }
                    if (!in_array($request->harga_add, $itemAttributes['detail_addon_id'])) {
                        $itemAttributes['detail_addon_id'][] = $request->harga_add;
                        $existingItem['attributes'] = $itemAttributes;
                
                        // Tambahkan kuantitas baru ke item yang sudah ada tanpa mengakumulasikan
                        $cart = \Cart::session(Auth::user()->id);
                        $cart->update($existingItem['id'], [
                            'quantity' => $existingItem['quantity'] + $request->qty, // Tambahkan kuantitas yang baru
                            'attributes' => $existingItem['attributes']
                        ]);
                    } else {
                        // Jika item dengan add-on detail yang sama sudah ada di dalam Cart, tambahkan kuantitas yang baru
                        $cart = \Cart::session(Auth::user()->id);
                        $cart->update($existingItem['id'], [
                            'quantity' => $request->qty, // Gunakan kuantitas yang baru
                            'attributes' => $existingItem['attributes']
                        ]);
                    }
                } else {
                    // Jika item dengan add-on detail tertentu belum ada di dalam Cart, tambahkan data cart baru
                    \Cart::session(Auth::user()->id)->add(array(
                        'id' => $itemIdentifier, // Gunakan kunci unik sebagai ID item
                        'name' => $restaurant->nama,
                        'price' => ($restaurant->harga_diskon + (is_array($dataHargaAddon) ? array_sum($dataHargaAddon) : 0) ?? $restaurant->harga_diskon),
                        'quantity' => $request->qty,
                        'attributes' => $addonDetail,
                        'conditions' => 'Restaurant',
                        'associatedModel' => Restaurant::class
                    ));
                }
                
                $category = $request->category;
                return redirect()->route('daftar-restaurant', ['category' => $category])->with('success', 'Berhasil masuk cart!');
            // }else{
            //     return redirect()->back()->with('failed', 'Silahkan Tanya Waiters');

            // }

            // Mengambil konten Cart berdasarkan user ID
            // $cartContent = \Cart::session(Auth::user()->id)->getContent();
        
            // Membuat array dari add-on detail untuk digunakan sebagai kunci unik
           
        } else {
            $user = 'guest';
            // \Cart::session($user)->add(array(
            //     'id' => $restaurant->id, // inique row ID
            //     'name' => $restaurant->nama,
            //     'price' => ($restaurant->harga_diskon + (is_array($dataHargaAddon) ? array_sum($dataHargaAddon) : 0) ?? $restaurant->harga_diskon),
            //     'quantity' => $request->qty,
            //     // 'attributes' => array($restaurant),
            //     'attributes' => array(
            //         'restaurant' => $restaurant,
            //         'category' => $request->category,
            //         'add_on_title' => $request->add_on_title,
            //         // 'harga_add' => array_sum($dataHargaAddon),
            //         'harga_add' => $dataHargaAddon,
            //         'detail_addon_id' => $request->harga_add,
            //     ),
            //     'conditions' => 'Restaurant',
            //     'associatedModel' => Restaurant::class
           
            // ));

            // return redirect()->back()->with('failed', 'Silahkan Tanya Waiters');

            // Mengambil konten Cart berdasarkan user ID
            $cartContent = \Cart::session($user)->getContent();
        
            // Membuat array dari add-on detail untuk digunakan sebagai kunci unik
            $addonDetail = array(
                'restaurant' => $restaurant,
                'category' => $request->category,
                'add_on_title' => $request->add_on_title,
                'harga_add' => $dataHargaAddon,
                'detail_addon_id' => $request->harga_add,
                'add_on_nama_title' => $request->add_on_nama_title,
                'add_nama' => $request->add_nama,
            );
        
            // Mengkonversi array add-on detail menjadi JSON untuk digunakan sebagai kunci unik
            $itemIdentifier = md5(json_encode($addonDetail));
        
            // Memeriksa apakah item dengan add-on detail yang sama sudah ada di dalam Cart
            $existingItem = $cartContent->first(function ($item, $key) use ($itemIdentifier) {
                return $item->id === $itemIdentifier;
            });
        
            // kode lama
            if ($existingItem !== null) {
                // Jika item dengan add-on detail yang sama sudah ada di dalam Cart
                // Buat array baru dengan membawa detail add-on ID yang berbeda
                $itemAttributes = $existingItem->attributes->toArray();
                if (!in_array($request->harga_add, $itemAttributes['detail_addon_id'])) {
                    $itemAttributes['detail_addon_id'] = $request->harga_add;
                    $existingItem->attributes = $itemAttributes;
                    $existingItem->quantity += $request->qty;
                    \Cart::session($user)->update($existingItem->id, $existingItem->toArray());
                }
            } 
            // if ($existingItem !== null) {
            //     // Jika item dengan add-on detail yang sama sudah ada di dalam Cart
            //     // Buat array baru dengan membawa detail add-on ID yang berbeda
            //     $itemAttributes = $existingItem->attributes->toArray();
                
            //     // Check if the detail_addon_id is an array
            //     if (!is_array($itemAttributes['detail_addon_id'])) {
            //         $itemAttributes['detail_addon_id'] = []; // Initialize as an array
            //     }
            
            //     if (!in_array($request->harga_add, $itemAttributes['detail_addon_id'])) {
            //         $itemAttributes['detail_addon_id'][] = $request->harga_add;
            //         $existingItem->attributes = $itemAttributes;
            //         $existingItem->quantity += $request->qty;
            //         \Cart::session($user)->update($existingItem->id, $existingItem->toArray());
            //     }
            // }
                else {
                // Jika item dengan add-on detail tertentu belum ada di dalam Cart, tambahkan data cart baru
                \Cart::session($user)->add(array(
                    'id' => $itemIdentifier, // Gunakan kunci unik sebagai ID item
                    'name' => $restaurant->nama,
                    'price' => ($restaurant->harga_diskon + (is_array($dataHargaAddon) ? array_sum($dataHargaAddon) : 0) ?? $restaurant->harga_diskon),
                    'quantity' => $request->qty,
                    'attributes' => $addonDetail,
                    'conditions' => 'Restaurant',
                    'associatedModel' => Restaurant::class
                ));
            }
            
            $category = $request->category;
            return redirect()->route('daftar-restaurant', ['category' => $category])->with('success', 'Berhasil Masuk Cart !');
        }
        // } catch (\Throwable $th) {
        //     return redirect()->back()->with('failed', $th->getMessage());
        // }
        
    }

    public function updateCart(Request $request)
    {
        // dd($request->id);
        // $totalPrice = $request->qty * $price;
        // update the item on cart
        // \Cart::session(Auth::user()->id)->add($request->id,[
        //     'quantity' => $request->qty,
        //     // 'price' => $totalPrice
        // ]);
        // update the item on cart
        // \Cart::session(Auth::user()->id)->update($request->id,[
        //     'quantity' => $request->qty,
        // ]);
        // Cart::update($request->id, array(
        //     'quantity' => $request->qty, // so if the current product has a quantity of 4, another 2 will be added so this will result to 6
        // ));
        // OrderPivot::create([
        //     'restaurant_id' => $request->id,
        //     'qty' => $request->qty,
        // ]);
                // item cart diupdate sesuai dengan qty yang diinput
        \Cart::session(Auth::user()->id)->update($request->id, [
            'quantity' => array(
                'relative' => false,
                'value' => $request->qty
            ),
        ]);

    }

    public function updateCartGuest(Request $request)
    {
        $user = auth()->guest() ? 'guest' : auth()->user()->id;
        \Cart::session($user)->update($request->id, [
            'quantity' => [
                'relative' => false,
                'value' => $request->qty
            ],
        ]);

        return response()->json(['success' => true]);

        // if($request->id && $request->quantity){
        //     $cart = session()->get('cart');
        //     $cart[$request->id]["quantity"] = $request->quantity;
        //     session()->put('cart', $cart);
        //     session()->flash('success', 'Cart successfully updated!');
        // }
    }



    public function deleteCartRestaurant($id)
    {
        if (Auth::check()) {
            # code...
            \Cart::session(Auth::user()->id)->remove($id);
        }
        $user = 'guest';
        \Cart::session($user)->remove($id);
        return redirect()->back();
    }


    public function viewCartBilliard()
    {
        $data ['billiard'] = Biliard::get();
        $data['data_carts'] = \Cart::session(Auth::user()->id)->getContent();

        return view('cart.biliard',$data);
    }

    public function addCartBilliard(Request $request,$id)
    {

        $paket_menu = MenuPackages::findOrFail($id);
        if ($request->quantity) {
            $quantity = $request->quantity;
        } else {
            $quantity = 0;
        }

        // $auth = User::get();
        // dd($request->all());

        // Pengecekan Login
        if (Auth::check()) {
            \Cart::session(Auth::user()->id)->add(array(
                'id' => $paket_menu->id, // inique row ID
                'name' => $paket_menu->nama_paket,
                'price' => $paket_menu->harga + array_sum($request->harga_paket),
                'quantity' => $request->quantity,
                // 'attributes' => array($paket_menu),
                'attributes' => array(
                    'paket_restaurant_id' => $request->paket_restaurant_id,
                    'paket_menu' => $paket_menu,
                    'category' => $request->category,
                    'harga_paket' => $request->harga_paket,
                    'jam' => $request->jam,
                ),
                'conditions' => 'Paket Menu',
                'associatedModel' => $paket_menu
            ));
            return redirect()->route('daftar-billiard')->with('message', 'Data berhasil dimasukkan ke dalam keranjang !');
        } else {
            return redirect()->route('daftar-billiard')->with('message', 'Harap Login Terlebih Dahulu !');
        }
    }

    public function viewCartMeetingRoom($id)
    {
        $data ['meeting-room'] = MeetingRoom::get();

        $data['cart_meeting_room'] = \Cart::session(Auth::user()->id)->getContent();
        return view('cart.meeting-room',$data);
    }

    public function editMeeting($id)
    {
        $data['meeting_room'] = MeetingRoom::find($id);

        return view('cart.meeting-room',$data);
    }


    public function addCartMeeting(Request $request,$id)
    {

        $paket_menu = MenuPackages::findOrFail($id);
        if ($request->quantity) {
            $quantity = $request->quantity;
        } else {
            $quantity = 0;
        }

        // $auth = User::get();
        // dd($request->all());

        // Pengecekan Login
        if (Auth::check()) {
            \Cart::session(Auth::user()->id)->add(array(
                'id' => $paket_menu->id, // inique row ID
                'name' => $paket_menu->nama_paket,
                'price' => $paket_menu->harga + array_sum($request->harga_paket),
                'quantity' => $request->quantity,
                // 'attributes' => array($paket_menu),
                'attributes' => array(
                    'paket_restaurant_id' => $request->paket_restaurant_id,
                    'paket_menu' => $paket_menu,
                    'category' => $request->category,
                    'harga_paket' => $request->harga_paket,
                    'jam' => $request->jam,
                ),
                'conditions' => 'Paket Menu Meeting',
                'associatedModel' => $paket_menu
            ));
            return redirect()->route('daftar-meeting-room')->with('message', 'Data berhasil dimasukkan ke dalam keranjang !');
        } else {
            return redirect()->route('daftar-meeting-room')->with('message', 'Harap Login Terlebih Dahulu !');
        }
    }

    public function deleteCart($id)
    {
        if (Auth::check()) {
            # code...
            \Cart::session(Auth::user()->id)->remove($id);
        }
        $user = 'guest';
        \Cart::session($user)->remove($id);
        return redirect()->back();
    }

    public function midtransCheck(Request $request)
    {
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = 'SB-Mid-server-8mUIYiml1lrBsWLE8yow0K8j';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => 10000,
            ),
            'customer_details' => array(
                'first_name' => 'budi',
                'last_name' => 'pratama',
                'email' => 'budi.pra@example.com',
                'phone' => '08111222333',
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return view('checkout.tes',['snap_token' =>$snapToken]);
    }
}
