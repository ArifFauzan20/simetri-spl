<?php

namespace App\Http\Controllers\WorkerOfficer;

use App\Http\Controllers\Controller;
use App\Models\Bagian;
use Illuminate\Http\Request;

class BagianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $bagian = Bagian::latest()->get();
        return view('page.worker-officer.data-bagian.index', [
            'title' => 'Data Bagian'
        ], compact('bagian'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'nama_bagian' => 'required|unique:r_bagian,nama_bagian'
        ], [
            'nama_bagian.required' => 'Nama bagian harus diisi',
            'nama_bagian.unique' => 'Nama bagian sudah ada'
        ]);

        try {
            Bagian::create([
                'nama_bagian' => $request->nama_bagian,
                'update_by' => auth()->user()->karyawan->nama_karyawan
            ]);
            return redirect()->back()->with('toast_success', 'Data berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('toast_error', 'Data gagal ditambahkan');
        }
    }

    public function update(Request $request)
    {
        $validate = $request->validate([
            'nama_bagian' => 'required|unique:r_bagian,nama_bagian,' . $request->id
        ], [
            'nama_bagian.required' => 'Nama bagian harus diisi',
            'nama_bagian.unique' => 'Nama bagian sudah ada'
        ]);

        try {
            Bagian::where('id', $request->id)->update([
                'nama_bagian' => $request->nama_bagian,
                'update_by' => auth()->user()->karyawan->nama_karyawan
            ]);
            return redirect()->back()->with('toast_success', 'Data berhasil diubah');
        } catch (\Throwable $th) {
            return redirect()->back()->with('toast_error', 'Data gagal diubah');
        }
    }

    public function delete(Request $request)
    {
        try {
            Bagian::where('id', $request->id)->delete();
            return redirect()->back()->with('toast_success', 'Data berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()->with('toast_error', 'Data gagal dihapus');
        }
    }
}
