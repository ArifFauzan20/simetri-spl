<?php

namespace App\Http\Controllers\WorkerOfficer;

use App\Exports\DetailSplExport;
use App\Exports\SingleKaryawanExport;
use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class DataPengajuanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $employees = Karyawan::all();
        $dataPengajuan = DB::table('t_spl')
            ->join('t_detail_spl', 't_spl.id', '=', 't_detail_spl.spl_id')
            ->join('t_karyawan', 't_detail_spl.karyawan_id', '=', 't_karyawan.id')
            ->join('r_bagian', 't_karyawan.bagian_id', '=', 'r_bagian.id')
            ->join('t_approval', 't_spl.id', '=', 't_approval.spl_id')
            ->select(
                't_spl.kode_proyek',
                't_spl.tgl_pengajuan',
                't_karyawan.nik_karyawan',
                't_karyawan.nama_karyawan',
                'r_bagian.nama_bagian',
                't_approval.status',
            )
            ->where('t_approval.status', '=', '2')
            ->orderBy('t_spl.tgl_pengajuan', 'desc')
            ->get();

        return view('page.worker-officer.data-pengajuan.index', [
            'title' => 'Data Pengajuan'
        ], compact('dataPengajuan', 'employees'));
    }

    public function findEmployee()
    {
        $nama_karyawan = request('nama_karyawan');
        $karyawan = Karyawan::where('nama_karyawan', 'like', '%' . $nama_karyawan . '%')->first();
        return response()->json($karyawan);
    }

    public function export(Request $request)
    {
        $sdate = $request->sdate;
        $edate = $request->edate;
        return Excel::download(new DetailSplExport($sdate, $edate), 'SPL' . ' ' . Carbon::parse($sdate)->format('d-M-Y') . ' to ' . Carbon::parse($edate)->format('d-M-Y') . '.xlsx');
    }

    public function exportOne(Request $request)
    {
        $nik = $request->nik;
        $sdate = $request->sdate;
        $edate = $request->edate;
        return Excel::download(new SingleKaryawanExport($sdate, $edate, $nik), 'SPL' . ' ' . $nik . '-' . Carbon::parse($sdate)->format('d-M-Y') . '-' . Carbon::parse($edate)->format('d-M-Y') .  '.xlsx');
    }
}
