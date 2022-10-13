<?php

namespace App\Http\Controllers\Finance;

use Carbon\Carbon;
use App\Models\Approval;
use App\Models\DetailSpl;
use Illuminate\Http\Request;
use App\Exports\DetailSplExport;
use App\Exports\SingleKaryawanExport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Spl;
use Maatwebsite\Excel\Facades\Excel;

class FinanceController extends Controller
{
    // middleware protech page if not login or not role finance
    public function __construct()
    {
        $this->middleware('auth');
    }

    // index page finance
    public function index()
    {
        $detailspl = Spl::all();
        $approval = Approval::with('spl')->where('status', '2')->get();

        $waiting_spv = DB::table('t_approval')
            ->where('status', '5')
            ->count();

        $waiting_head = DB::table('t_approval')
            ->where('status', '6')
            ->count();

        $pengajuan_terakhir = DB::table('t_spl')
            ->join('t_approval', 't_spl.id', '=', 't_approval.spl_id')
            ->orderBy('t_spl.created_at', 'desc')
            ->where('t_approval.status', '2')
            ->get();

        $total = $detailspl->count();
        $total_approval = $approval->count();
        return view('page.finance.index', [
            'title' => 'Finance'

        ], compact('total', 'total_approval', 'waiting_spv', 'waiting_head', 'pengajuan_terakhir'));
    }

    // show all data function
    public function showData()
    {
        $employees = Karyawan::all();
        $details = DB::table('t_spl')
            ->join('t_approval', 't_spl.id', '=', 't_approval.spl_id')
            ->join('t_detail_spl', 't_spl.id', '=', 't_detail_spl.spl_id')
            ->join('t_karyawan', 't_detail_spl.karyawan_id', '=', 't_karyawan.id')
            ->join('r_bagian', 't_karyawan.bagian_id', '=', 'r_bagian.id')
            ->select('t_spl.id_spl', 't_spl.kode_proyek', 't_karyawan.nik_karyawan', 't_karyawan.nama_karyawan', 'r_bagian.nama_bagian', 't_spl.tgl_pengajuan', 't_approval.keterangan')
            ->where('t_approval.status', '2')
            ->orderBy('t_spl.tgl_pengajuan', 'desc')
            ->get();

        return view('page.finance.data-pengajuan.index', [
            'title' => 'Finance'
        ], compact('details', 'employees'));
    }

    // function find data by nama karyawan
    public function findEmployee()
    {
        $nama_karyawan = request('nama_karyawan');
        $karyawan = Karyawan::where('nama_karyawan', 'like', '%' . $nama_karyawan . '%')->first();
        return response()->json($karyawan);
    }

    // function export data to excel
    public function export(Request $request)
    {
        $sdate = $request->sdate;
        $edate = $request->edate;
        return Excel::download(new DetailSplExport($sdate, $edate), 'SPL' . ' ' . Carbon::parse($sdate)->format('d-M-Y') . ' to ' . Carbon::parse($edate)->format('d-M-Y') . '.xlsx');
    }

    // function export data to excel by nama karyawan
    public function exportOne(Request $request)
    {
        $nik = $request->nik;
        $sdate = $request->sdate;
        $edate = $request->edate;
        return Excel::download(new SingleKaryawanExport($sdate, $edate, $nik), 'SPL' . ' ' . $nik . '-' . Carbon::parse($sdate)->format('d-M-Y') . '-' . Carbon::parse($edate)->format('d-M-Y') .  '.xlsx');
    }

    // function dashboard finance
    public function getDashboard()
    {
        $month = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];

        for ($i = 0; $i < count($month); $i++) {
            $total[$i] = DB::table('t_spl')
                ->whereMonth('created_at', $month[$i])
                ->whereYear('created_at', Carbon::now()->year)
                ->count();
        }

        return response()->json([
            'label' => [
                'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
            ],
            'month' => $total,
        ]);
    }
}
