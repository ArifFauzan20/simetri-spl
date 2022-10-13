<?php

namespace App\Http\Controllers\WorkerOfficer;

use App\Http\Controllers\Controller;
use App\Models\Bagian;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class AdminLabourController extends Controller
{
    // middleware protech page if not login or not role admin labour
    public function __construct()
    {
        $this->middleware('auth');
    }

    // index page admin labour
    public function index()
    {
        $labours = Karyawan::with('bagian')->latest()->get();
        return view('page.worker-officer.data-labour.index', [
            'title' => 'Admin Labour',
        ], compact('labours'));
    }

    // function for store data labour
    public function create()
    {
        $departments = Bagian::all();
        $labours = Http::get('http://192.168.1.99:8080/simetri-api-local/api/local/employees')['data'];
        // $labours = Http::get('http://system.sinarmetrindo.co.id:18881/simetri-api-local/api/local/employees')['data'];
        // $labours = Http::get('http://127.0.0.1:8000/api/local/employees')['data'];
        return view('page.worker-officer.data-labour.create', [
            'title' => 'Admin Labour',
        ], compact('departments', 'labours'));
    }

    // function for create data labour
    public function createLabour(Request $request)
    {
        $validateData = $request->validate([
            'nik_karyawan' => 'required',
            'nama_karyawan' => 'required',
            'bagian_id' => 'required',
            'status_kontrak' => 'required',
            'tarif_lembur' => 'required',
        ], [
            'nik_karyawan.required' => 'NIK Karyawan tidak boleh kosong',
            'nik_karyawan.unique' => 'NIK Karyawan sudah ada',
            'nama_karyawan.required' => 'Nama Karyawan tidak boleh kosong',
            'bagian_id.required' => 'Bagian Karyawan tidak boleh kosong',
            'status_kontrak.required' => 'Status Kontrak tidak boleh kosong',
            'tarif_lembur.required' => 'Tarif Lembur tidak boleh kosong',
        ]);

        if (auth()->user()->role_id == 5) {
            $update_by = auth()->user()->karyawan->nama_karyawan;
        }

        $validateData['update_by'] = $update_by;
        Karyawan::create($validateData);
        return redirect()->route('adminwo.data-labour')->with('toast_success', 'Data Karyawan Berhasil Ditambahkan');
    }

    // function for edit data labour
    public function show($id)
    {
        $labour = Karyawan::find($id);
        $departments = Bagian::all();
        // $employee = Http::get('http://192.168.1.99:8080/simetri-api-local/api/local/employee/' . $labour->nama_karyawan); // get data from api
        // $employee = Http::get('http://system.sinarmetrindo.co.id:18881/simetri-api-local/api/local/employee/' . $labour->nama_karyawan)['data']; //maintenance if not connect to local network

        $employees = Http::get('http://192.168.1.99:8080/simetri-api-local/api/local/employees')['data']; // get data from api
        // $employees = Http::get('http://system.sinarmetrindo.co.id:18881/simetri-api-local/api/local/employees')['data']; //maintenance if not connect to local network
        // $employee = Http::get('http://127.0.0.1:8000/api/local/employee/' . $labour->nama_karyawan)['data'];  // maintenance if not connect to local network
        // dd($employees);

        return view('page.worker-officer.data-labour.show', [
            'title' => 'Admin Labour',
        ], compact('labour', 'departments', 'employees'));
    }

    // function for update data labour
    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'nik_karyawan' => 'required',
            'nama_karyawan' => 'required',
            'bagian_id' => 'required',
            'status_kontrak' => 'required',
            'tarif_lembur' => 'required',
        ], [
            'nik_karyawan.required' => 'NIK Karyawan tidak boleh kosong',
            'nik_karyawan.unique' => 'NIK Karyawan sudah ada',
            'nama_karyawan.required' => 'Nama Karyawan tidak boleh kosong',
            'bagian_id.required' => 'Bagian Karyawan tidak boleh kosong',
            'status_kontrak.required' => 'Status Kontrak tidak boleh kosong',
            'tarif_lembur.required' => 'Tarif Lembur tidak boleh kosong',
        ]);


        $labour = Karyawan::find($id);
        $labour->update($validateData);
        return redirect()->route('adminwo.data-labour')->with('toast_success', 'Data Karyawan Berhasil Diubah');
    }

    // function for delete data labour
    public function delete(Request $request)
    {
        $labour = Karyawan::find($request->id);
        $labour->delete();
        return redirect()->route('adminwo.data-labour')->with('toast_success', 'Data Karyawan Berhasil Dihapus');
    }

    // function for search data labour
    public function findEmployee($nik, $nama)
    {
        $employee = Http::get('http://192.168.1.99:8080/simetri-api-local/api/local/employee/' . $nik . '/' . $nama)['data']; // get data from api
        // $employee = Http::get('http://system.sinarmetrindo.co.id:18881/simetri-api-local/api/local/employee/' . $nik . '/' . $nama)['data']; //maintenance if not connect to local network
        // $employee = Http::get('http://127.0.0.1:8000/api/local/employee/' . $nik . '/' . $nama)['data']; //maintenance if not connect to local network
        return response()->json($employee);
    }
}
