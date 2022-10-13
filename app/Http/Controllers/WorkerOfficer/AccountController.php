<?php

namespace App\Http\Controllers\WorkerOfficer;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use function GuzzleHttp\Promise\all;

class AccountController extends Controller
{
    // middleware protech page if not login or not role worker officer
    public function __construct()
    {
        $this->middleware('auth');
    }
    // index page worker officer
    public function index()
    {
        $users = User::with('karyawan', 'role', 'karyawan.bagian')
            ->where('role_id', '!=', 1)
            ->latest()->get();
        $employees = Karyawan::all();
        $roles = Role::where('id', '!=', 1)->get();

        return view('page.worker-officer.data-akun.index', [
            'title' => 'Data Akun'
        ], compact('users', 'employees', 'roles'));
    }

    // find data karyawan
    public function findEmployee($name, $nik)
    {
        $employee = Karyawan::where('nama_karyawan', 'like', '%' . $name . '%')
            ->where('nik_karyawan', $nik)
            ->get();
        return response()->json($employee);
    }

    // function for store data user
    public function store(Request $request)
    {

        $validated = $request->validate([
            'nik_karyawan' => 'required',
            'password' => 'required',
            'role_id' => 'required',
            'status_user' => 'required',
        ], [
            'nik_karyawan.required' => 'NIK harus diisi!',
            'password.required' => 'Password harus diisi!',
            'role_id.required' => 'Role harus diisi!',
            'status_user.required' => 'Status harus diisi!',
        ]);

        try {
            $user = User::create([
                'karyawan_id' => $request->karyawan_id,
                'nik_karyawan' => $request->nik_karyawan,
                'status_user' => $request->status_user,
                'password' => bcrypt($request->password),
                'role_id' => $request->role_id,
                'last_login' => Carbon::now(),
                'update_by' => auth()->user()->karyawan->nama_karyawan,
            ]);
            return redirect()->route('adminwo.data-akun')->with('toast_success', 'Data berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->route('adminwo.data-akun')->with('toast_error', $e->getMessage());
        }
    }

    // function for update data user
    public function edit(Request $request)
    {
        $validated = $request->validate([
            'nik_karyawan_edit' => 'required',
            'role_id_edit' => 'required',
            'status_user_edit' => 'required',
        ], [
            'nik_karyawan_edit.required' => 'NIK harus diisi!',
            'role_id_edit.required' => 'Role harus diisi!',
            'status_user_edit.required' => 'Status harus diisi!',
        ]);

        $user = User::find($request->id_edit);

        try {
            $user->update([
                'karyawan_id' => $request->karyawan_id_edit,
                'nik_karyawan' => $request->nik_karyawan_edit,
                'status_user' => $request->status_user_edit,
                'role_id' => $request->role_id_edit,
                'update_by' => auth()->user()->karyawan->nama_karyawan,
            ]);
            return redirect()->route('adminwo.data-akun')->with('toast_success', 'Data berhasil diubah!');
        } catch (\Exception $e) {
            return redirect()->route('adminwo.data-akun')->with('toast_error', 'Data gagal diubah!');
        }
    }

    // function for reset password
    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'newPassword' => 'required',
        ], [
            'newPassword.required' => 'Password harus diisi!',
        ]);

        $user = User::find($request->id_reset);

        try {
            $user->update([
                'password' => bcrypt($request->newPassword),
                'update_by' => auth()->user()->karyawan->nama_karyawan,
            ]);
            return redirect()->route('adminwo.data-akun')->with('toast_success', 'Password berhasil diubah!');
        } catch (\Exception $e) {
            return redirect()->route('adminwo.data-akun')->with('toast_error', 'Password gagal diubah!');
        }
    }

    // function for delete data user
    public function delete(Request $request)
    {
        $user = User::find($request->id_delete);

        try {
            $user->delete();
            return redirect()->route('adminwo.data-akun')->with('toast_success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('adminwo.data-akun')->with('toast_error', 'Data gagal dihapus!');
        }
    }
}
