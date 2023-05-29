<?php

namespace App\Http\Controllers;

use App\Models\Biliard;
use App\Models\CartOrders;
use App\Models\MeetingRoom;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Gloudemans\Shoppingcart\facades\Cart;
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
        $data ['restaurant'] = Restaurant::get();
        $data['data_carts'] = \Cart::session(Auth::user()->id)->getContent();
        return view('cart.index',$data);
    }

    public function storeCart(Request $request )
    {
        $restaurant = Restaurant::findOrFail($request->input('restaurant_id'));
        Cart::add(
            $restaurant->id,
            $restaurant->nama,
            $request->input('quantity'),
            $request->harga/100,
        );
        return redirect()->route('cart')->with(['message' => 'Cart Berhasil Dimasukkan!']);
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

        $meeting_room = MeetingRoom::findOrFail($id);
        if ($request->quantity) {
            $quantity = $request->quantity;
        } else {
            $quantity = 0;
        }


        // $auth = User::get();
        // dd($auth->id);

        // Pengecekan Login
        if (Auth::check()) {
            \Cart::session(Auth::user()->id)->add(array(
                'id' => $meeting_room->id, // inique row ID
                'name' => $meeting_room->nama,
                'price' => $meeting_room->harga,
                'quantity' => $quantity,
                'attributes' => array(),
                'associatedModel' => MeetingRoom::class
            ));
            return redirect()->route('cart-meeting-room')->with('message', 'Data berhasil dimasukkan ke dalam keranjang !');
        } else {
            return redirect()->route('cart-meeting-room')->with('message', 'Harap Login Terlebih Dahulu !');
        }


    }

    public function deleteCart($id)
    {
        \Cart::session(Auth::user()->id)->remove($id);
        return redirect()->back();
    }

    public function addCartRestaurant(Request $request,$id)
    {

        $restaurant = Restaurant::findOrFail($id);
        if ($request->quantity) {
            $quantity = $request->quantity;
        } else {
            $quantity = 0;
        }

        // $auth = User::get();
        // dd($auth->id);

        // Pengecekan Login
        if (Auth::check()) {
            \Cart::session(Auth::user()->id)->add(array(
                'id' => $restaurant->id, // inique row ID
                'name' => $restaurant->nama,
                'price' => $restaurant->harga,
                'quantity' => $quantity,
                'attributes' => array(),
                'associatedModel' => Restaurant::class
            ));
            return redirect()->route('homepage')->with('message', 'Data berhasil dimasukkan ke dalam keranjang !');
        } else {
            return redirect()->route('homepage')->with('message', 'Harap Login Terlebih Dahulu !');
        }


    }

    public function deleteCartRestaurant($id)
    {
        \Cart::session(Auth::user()->id)->remove($id);
        return redirect()->back();
    }

    public function viewCartBiliard()
    {
        $data ['biliards'] = Biliard::get();

        $data['cart_meeting_room'] = \Cart::session(Auth::user()->id)->getContent();
        return view('cart.meeting-room',$data);
    }

    public function editBiliard($id)
    {
        $data['biliards'] = Biliard::find($id);

        return view('cart.biliard',$data);
    }


    public function addCartBiliard(Request $request,$id)
    {

        $meeting_room = Biliard::findOrFail($id);
        if ($request->quantity) {
            $quantity = $request->quantity;
        } else {
            $quantity = 0;
        }


        // $auth = User::get();
        // dd($auth->id);

        // Pengecekan Login
        if (Auth::check()) {
            \Cart::session(Auth::user()->id)->add(array(
                'id' => $meeting_room->id, // inique row ID
                'name' => $meeting_room->nama,
                'price' => $meeting_room->harga,
                'quantity' => $quantity,
                'attributes' => array(),
                'associatedModel' => Biliard::class
            ));
            return redirect()->route('cart-meeting-room')->with('message', 'Data berhasil dimasukkan ke dalam keranjang !');
        } else {
            return redirect()->route('cart-meeting-room')->with('message', 'Harap Login Terlebih Dahulu !');
        }


    }

    public function deleteCartBiliard($id)
    {
        \Cart::session(Auth::user()->id)->remove($id);
        return redirect()->back();
    }
}
