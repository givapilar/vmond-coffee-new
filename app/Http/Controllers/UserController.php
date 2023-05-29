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
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function edit($id)
    {
        $data['page_title'] = 'Edit User';
        $data['breadcumb'] = 'Edit';
        $data['user'] = User::findOrFail($id);

        return view('user.profile', $data);
    }

    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            // 'name'   => 'required|string|min:3',
            'username'   => 'required|alpha_dash|unique:users,username,'.$id,
            'email'   => 'required',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $user = User::findOrFail($id);
        $user->username = $validateData['username'];
        $user->email = $validateData['email'];


        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('assets/images/user/');
            $image->move($destinationPath, $name);
            $user->avatar = $name;
        }

        $user->save();

        // DB::table('model_has_roles')->where('model_id',$id)->delete();
        // $user->assignRole($validateData['role']);

        return redirect()->route('homepage')->with(['success' => 'User edited successfully!']);
    }
}
