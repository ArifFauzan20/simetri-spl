<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Bagian;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Karyawan::latest()->get();
        $divisions = Bagian::all();
        return view('page.admin.employee.index', [
            'title' => 'Karyawan',
            'header' => 'Karyawan',
        ], compact('employees', 'divisions'));
    }

    public function checkEmployee()
    {
        $nik_karyawan = request('nik_karyawan');
        $nama_karyawan = request('nama_karyawan');

        $nik = Karyawan::where('nik_karyawan', $nik_karyawan)->first();
        $nama = Karyawan::where('nama_karyawan', $nama_karyawan)->first();

        if ($nik || $nama) {
            return response()->json(['status' => 'error', 'nik' => $nik]);
        } else {
            return response()->json(['status' => 'success'],);
        }
    }

    public function createEmployee(Request $request)
    {
        $validated = $request->validate([
            'nik_karyawan' => 'required|unique:t_karyawan',
            'nama_karyawan' => 'required',
            'bagian_id' => 'required',
            'tarif_lembur' => 'required',
            'status_kontrak' => 'required',
        ], [
            'nik_karyawan.required' => 'NIK Karyawan tidak boleh kosong',
            'nik_karyawan.unique' => 'NIK Karyawan sudah terdaftar',
            'nama_karyawan.required' => 'Nama Karyawan tidak boleh kosong',
            'bagian_id.required' => 'Bagian tidak boleh kosong',
            'tarif_lembur.required' => 'Tarif Lembur tidak boleh kosong',
            'status_kontrak.required' => 'Status Kontrak tidak boleh kosong',
        ]);


        if (auth()->user()->role_id == 1) {
            $update_by = 'Super Admin';
        }

        $validated['update_by'] = $update_by;
        try {
            Karyawan::create($validated);
            Alert::toast('Data karyawan berhasil ditambah', 'success');
            return redirect()->route('superadmin.employee')->with('toast_success', 'Data Karyawan Berhasil Ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->route('superadmin.employee')->with('toast_error', 'Data Karyawan Gagal Ditambahkan');
        }
    }

    public function updateEmployee(Request $request)
    {
        $validated = $request->validate([
            'nik_karyawan' => 'required',
            'nama_karyawan' => 'required',
            'bagian_id' => 'required',
            'tarif_lembur' => 'required',
            'status_kontrak' => 'required',
        ]);

        if (auth()->user()->role_id == 1) {
            $update_by = 'Super Admin';
        }

        try {
            $validated['update_by'] = $update_by;
            $employee = Karyawan::find($request->id);
            $employee->update($validated);
            return redirect()->route('superadmin.employee')->with('toast_success', 'Data Karyawan Berhasil Diubah');
        } catch (\Exception $e) {
            return redirect()->route('superadmin.employee')->with('toast_error', 'Data Karyawan Gagal Diubah');
        }
    }

    public function deleteEmployee(Request $request)
    {

        $employee = Karyawan::find($request->id);
        $employee->delete();
        return redirect()->route('superadmin.employee')->with('toast_success', 'Data Karyawan Berhasil Dihapus');
    }

    public function getEmployee()
    {
        $employee = Karyawan::where('nama_karyawan', request('nama_karyawan'))->first();
        return response()->json(['status' => 'success', 'employee' => $employee]);
    }

    public function getDivision()
    {
        $division = Bagian::where('nama_bagian', request('nama_bagian'))->first();
        return response()->json(['status' => 'success', 'division' => $division]);
    }
}
