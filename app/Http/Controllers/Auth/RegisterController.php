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
        ]);

        $user = new User();
        $user->username     = $validate['username'];
        $user->name         = $validate['username'];
        $user->telephone    = $validate['telephone'];
        $user->password     = Hash::make($validate['password']);
        $user->save();

        return redirect()->route('login')->with(['message_success' => 'Register account successfully!']);
    }
}
