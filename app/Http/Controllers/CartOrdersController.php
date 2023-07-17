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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
// use Gloudemans\Shoppingcart\facades\Cart;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
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
        $data ['restaurants'] = Restaurant::get();
        $data ['meja_restaurants'] = MejaRestaurant::get();
        $data ['biliards'] = Biliard::get();
        $data ['meeting_rooms'] = MeetingRoom::get();
        $data ['paket_menu'] = MenuPackages::get();
        $data ['order_settings'] = OtherSetting::get();
        // foreach ($tes as $key => $paket_menu) {
        //     return $paket = $paket_menu;
        // }
        // dd($paket_menu);
        $data['data_carts'] = \Cart::session(Auth::user()->id)->getContent();
        $data['condisi'] = Cart::getConditions();
        // dd ($cartConditions);
        // dd($data['data_carts']);
        
        $data_carts = \Cart::session(Auth::user()->id)->getContent();
        $processedCartItems = [];

        foreach ($data['data_carts'] as $cartItem) {
            // Access individual cart item properties
            $id = $cartItem->id;
            $name = $cartItem->name;
            $price = $cartItem->price;
            $quantity = $cartItem->quantity;
            $conditions = $cartItem->conditions;
            // ... and so on

            // Perform any necessary operations with the cart item
            // For example, you can store the cart item in an array or perform some calculations
            // You can also pass the cart item to a view or manipulate its data

            // Example operation: Storing cart item data in an array
            $cartItemData = [
                'id' => $id,
                'name' => $name,
                'price' => $price,
                'quantity' => $quantity,
                'conditions' => $conditions,
                // ... and so on
            ];

            // Store the cart item data in the $processedCartItems array
            $processedCartItems[] = $cartItemData;
        }

        $data['processedCartItems'] = $processedCartItems;

        return view('cart.index',$data);
    }

    public function addCartRestaurant(Request $request,$id)
    {
        $dataHargaAddon = [];
        if ($request->harga_add != null) {
            foreach ($request->harga_add as $key => $val) {
                $data_addOn = AddOnDetail::where('id', $val)->get();
                $dataHargaAddon[] = $data_addOn[0]->harga . '';
            }
        }

        // foreach ($request->add_on_title as $key => $val) {
        //     $data_addOn = AddOn::where('id', $val)->get();
        //     $dataHargaAddonTitle[] = $data_addOn[0]->nama . '';

        // }
        // dd($request->all());

        $restaurant = Restaurant::findOrFail($id);
        // dd($restaurant->addOns->isNotEmpty());

        $countAddOn = $request->harga_add ? count($request->harga_add) : 0;
        // dd($countAddOn);
        // dd($request->minimum);
        if (($countAddOn < $request->minimum) && $restaurant->addOns->isNotEmpty()) {
            return redirect()->back()->with(['failed' => 'Harap Pilih Add On Sesuai minimum !!']);
        }

        if ($request->quantity) {
            $quantity = $request->quantity;
        } else {
            $quantity = 0;
        }
        
        
        // $auth = User::get();
        // dd($auth->id);

        // Pengecekan Login
        
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
            \Cart::session(Auth::user()->id)->add(array(
                'id' => $restaurant->id, // inique row ID
                'name' => $restaurant->nama,
                'price' => ($restaurant->harga_diskon + (is_array($dataHargaAddon) ? array_sum($dataHargaAddon) : 0) ?? $restaurant->harga_diskon),
                'quantity' => $request->qty,
                // 'attributes' => array($restaurant),
                'attributes' => array(
                    'restaurant' => $restaurant,
                    'category' => $request->category,
                    'add_on_title' => $request->add_on_title,
                    // 'harga_add' => array_sum($dataHargaAddon),
                    'harga_add' => $dataHargaAddon,
                    'detail_addon_id' => $request->harga_add,
                ),
                'conditions' => 'Restaurant',
                'associatedModel' => $restaurant
            // \Cart::session(Auth::user()->id)->add(array(
            //     'id' => $request->id, // inique row ID
            //     'name' => $request->nama,
            //     'price' => $request->harga,
            //     'quantity' => $request->quantity,
            //     // 'attributes' => array($restaurant),
            //     'attributes' => array(
            //         'restaurant' => $restaurant,
            //         'category' => $request->category,
            //         'add_on_title' => $request->add_on_title,
            //         'harga_add' => $request->harga_add,
            //     ),
            //     'conditions' => 'Restaurant',
            //     'associatedModel' => $restaurant
            ));
            // dd($tes);
            $category = $request->category;
            return redirect()->route('daftar-restaurant', ['category' => $category])->with('success', 'Berhasil masuk cart!');
        } else {
            $category = $request->category;
            return redirect()->route('daftar-restaurant', ['category' => $category])->with('failed', 'Harap Login Terlebih Dahulu !');
        }
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
        \Cart::session(Auth::user()->id)->update($request->id,[
            'quantity' => $request->qty,
        ]);
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

    public function deleteCartRestaurant($id)
    {
        \Cart::session(Auth::user()->id)->remove($id);
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
        \Cart::session(Auth::user()->id)->remove($id);
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
