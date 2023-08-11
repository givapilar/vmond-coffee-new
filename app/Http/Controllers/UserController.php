<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\HistoryLog;
Use File;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function edit($id)
    {
        if (!Auth::user()) {
            return redirect()->route('homepage');
        }
        $id = explode('-', Crypt::decryptString($id)) ?? null;
        $id = $id[0];

        try {
            $data['page_title'] = 'Edit User';
            $data['breadcumb'] = 'Edit';
            $data['user'] = User::findOrFail($id);
        } catch (\Throwable $th) {
            return redirect()->route('homepage')->with(['failed' => 'Account not recognized!', 'auth' => Auth::user()->id, 'menu' => 'user-edit']);
        }

        return view('user.profile', $data);
    }

    public function update(Request $request, $id)
    {
        $id = explode('-', Crypt::decryptString($id)) ?? null;
        $id = $id[1];
        if (!$id || $id == null) {
            return redirect()->route('homepage')->with(['failed' => 'Account not recognized!', 'auth' => Auth::user()->id, 'menu' => 'user-update']);
        }

        try {
            $validateData = $request->validate([
                'username'      => 'required|string|min:5|unique:account_users,username,'.$id,
                'telephone'     => 'required|regex:/[0-9]/|min:11|max:13|unique:account_users,telephone,'.$id,
                // 'email'         => 'nullable|unique:account_users,email,'.$id,
                'address'       => 'nullable|string',
                'password'      => 'nullable|string|min:6',
                'new_password'  => 'nullable|string|min:6|required_with:password',
                'avatar'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $user = User::findOrFail($id);
            $user->username     = $validateData['username'];
            $user->telephone    = $validateData['telephone'];
            // $user->email        = $validateData['email'];
            $user->address      = $validateData['address'];

            if ($user && Hash::check( $validateData['password'], $user->password)) {
                $user->password = Hash::make($validateData['new_password']);
            }

            if ($request->hasFile('avatar')) {
                $image = $request->file('avatar');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assetku/dataku/img/user/');
                $image->move($destinationPath, $name);
                $user->avatar = $name;
            }

            $user->save();

            return redirect()->route('homepage')->with(['success' => 'Account successfully modified!', 'auth' => Auth::user()->id, 'menu' => 'user-update']);
        } catch (\Throwable $th) {
            if (!Auth::user()) {
                return redirect()->route('homepage');
            }
            return redirect()->route('homepage')->with(['failed' => 'Failed: '. $th->getMessage(), 'auth' => Auth::user()->id, 'menu' => 'user-update']);
        }
    }
}
