<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::latest()->get();
        $employees = Karyawan::all();
        $roles = Role::all();
        return view('page.admin.users.index', [
            'title' => 'Data Pengguna',
            'header' => 'data pengguna'
        ], compact('users', 'employees', 'roles'));
    }

    public function createUser(Request $request)
    {
        if (auth()->user()->role_id == 1) {
            $update_by = 'Super Admin';
        }

        $validatedData = Validator(
            $request->all(),
            [
                'nik_karyawan' => 'required|unique:t_user_login'
            ],
            [
                'nik_karyawan.unique' => 'User dengan NIK tersebut sudah terdaftar',
            ]
        );
        try {
            $user = User::create([
                'karyawan_id' => $request->karyawan_id,
                'nik_karyawan' => $request->nik_karyawan,
                'status_user' => $request->status_user,
                'password' => bcrypt($request->password),
                'role_id' => $request->role_id,
                'last_login' => Carbon::now(),
                'update_by' => $update_by,
            ]);
            return redirect()->route('superadmin.users')->with('toast_success', 'Data pengguna berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->route('superadmin.users')->with('toast_error', $validatedData->errors()->first());
        }
    }


    public function editUser($id)
    {
        $user = User::find($id);
        return response()->json(['success' => true, 'user' => [
            'id' => $user->id,
            'nik_karyawan' => $user->karyawan->nik_karyawan,
            'nama_karyawan' => $user->karyawan->nama_karyawan,
            'password' => $user->password,
            'status_user' => $user->status_user,
            'role_user' => $user->role->role_user,
        ]]);
    }

    public function updateUser(Request $request)
    {
        $validated = $request->validate([
            'password' => 'required',
        ]);

        if (Auth::user()->role_id == 1) {
            $updated_by = 'Super Admin';
        }

        User::where('id', $request->id)->update(
            [
                'password' => bcrypt($request->password),
                'status_user' => $request->status_user,
                'role_id' => $request->role_user,
                'update_by' => $updated_by,
                'updated_at' => date('Y-m-d H:i:s')
            ]
        );
        return redirect()->route('superadmin.users')->with('toast_success', 'Data pengguna berhasil diedit!');
    }

    public function deleteUser(Request $request)
    {
        User::where('id', $request->id)->delete();
        return redirect()->route('superadmin.users')->with('toast_success', 'Data pengguna berhasil dihapus!');
    }
}
