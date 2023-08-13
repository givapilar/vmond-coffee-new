<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('Auth.register');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validate = $request->validate([
            "username"              => "required|string|min:5|unique:account_users,username",
            "password"              => "required|string|min:6|required_with:password_confirmation|same:password_confirmation",
            "password_confirmation" => "min:6",
            "telephone"             => "required|regex:/[0-9]/|min:11|unique:account_users,telephone",
            "membership"             => "nullable",
        ]);

        $user = new User();
        $user->username     = $validate['username'];
        // $user->name         = $validate['username'];
        $user->telephone    = $validate['telephone'];
        $user->membership_id     = 1;
        $user->password     = Hash::make($validate['password']);

        if ($request->has('jenis_meja') && $request->has('kode_meja')) {
            $user->kode_meja = $request->kode_meja;
            $user->jenis_meja = $request->jenis_meja;
            $user->save();
        } 

        $user->save();

        return redirect()->route('login')->with(['message_success' => 'Register account successfully!']);
    }
}
