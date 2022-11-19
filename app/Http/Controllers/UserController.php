<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showListUserPage()
    {
        $data['users'] = User::with('role')->get();

        return view('user.index', $data);
    }

    public function showAddUserPage()
    {
        $data['roles'] = Role::all();

        return view('user.add', $data);
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'name' => 'required',
            'password' => 'required|confirmed',
            'role_id' => 'required',
        ]);

        $user = new User();
        $user->username = $request->username;
        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $user->role_id = $request->role_id;
        $user->save();

        return redirect('/user')->with('toast_success', 'Data petugas berhasil ditambah');
    }

    public function showEditUserPage($user_id)
    {
        $data['roles'] = Role::all();
        $data['user'] = User::find($user_id);

        return view('user.edit', $data);
    }

    public function updateUser(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username,' . $request->id,
            'name' => 'required',
            'password' => 'confirmed',
            'role_id' => 'required',
        ]);

        $user = User::find($request->id);
        $user->username = $request->username;
        $user->name = $request->name;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->role_id = $request->role_id;
        $user->save();

        return redirect('/user')->with('toast_success', 'Data petugas berhasil diubah');
    }

    public function destroyUser(Request $request)
    {
        User::destroy($request->id);

        return redirect('/user')->with('toast_success', 'Data petugas berhasil dihapus');
    }
}
