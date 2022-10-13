<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use Authenticatable;

    public function index()
    {
        return view('auth.login', [
            'title' => 'Login',
        ]);
    }

    // login function
    public function authlogin(Request $request)
    {
        $credentials = $request->validate([
            'nik_karyawan' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('nik_karyawan', 'like', '%' . $request->nik_karyawan . '%')->first();

        // check if user not exist
        if (!$user) {
            return back()->with('error', 'NIK atau Password salah!');
        }

        // check if user not active
        if ($user->status_user != 1) {
            return back()->with('error', 'Akun anda tidak aktif!');
        }

        // login if user role super admin
        if ($user->role_id == 1) {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                // update last login
                $user->last_login = Carbon::now();
                $user->save();
                return redirect()->intended('/superadmin');
            }
            return back()->with('error', 'NIK atau Password salah!');
        }

        // login if user role supervisor
        if ($user->role_id == 2) {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                // update last login
                $user->last_login = date('Y-m-d H:i:s');
                $user->save();
                return redirect()->intended('/supervisor');
            }
            return back()->with('error', 'NIK atau Password salah!');
        }

        // login if user role head / manager
        if ($user->role_id == 3) {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                // update last login
                $user->last_login = date('Y-m-d H:i:s');
                $user->save();
                return redirect()->intended('/head-production');
            }
            return back()->with('error', 'NIK atau Password salah!');
        }

        // login if user role finance
        if ($user->role_id == 4) {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                $user->last_login = date('Y-m-d H:i:s');
                $user->save();
                return redirect()->intended('/finance');
            }
            return back()->with('error', 'NIK atau Password salah!');
        }

        // login if user role admin WO
        if ($user->role_id == 5) {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                $user->last_login = date('Y-m-d H:i:s');
                $user->save();

                return redirect()->intended('/admin-worker-officer');
            }
            return back()->with('error', 'NIK atau Password salah!');
        }

        // login if user role koordinator
        if ($user->role_id == 6) {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                $user->last_login = date('Y-m-d H:i:s');
                $user->save();
                return redirect()->intended('/koordinator');
            }
            return back()->with('error', 'NIK atau Password salah!');
        }

        // login if user role labour
        if ($user->role_id == 7) {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                $user->last_login = date('Y-m-d H:i:s');
                $user->save();
                return redirect()->intended('/labour');
            }
            return back()->with('error', 'NIK atau Password salah!');
        }
    }

    // logout function
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
