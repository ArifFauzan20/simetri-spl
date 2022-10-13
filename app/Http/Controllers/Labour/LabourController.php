<?php

namespace App\Http\Controllers\Labour;

use App\Models\Approval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class LabourController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $detailspl = DB::table('t_spl')
            ->join('t_detail_spl', 't_spl.id', '=', 't_detail_spl.spl_id')
            ->join('t_karyawan', 't_detail_spl.karyawan_id', '=', 't_karyawan.id')
            ->join('r_bagian', 't_karyawan.bagian_id', '=', 'r_bagian.id')
            ->select('t_spl.id_spl')
            ->where('t_karyawan.nik_karyawan', auth()->user()->karyawan->nik_karyawan)
            ->orderBy('t_spl.id_spl', 'desc')
            ->distinct()
            ->get();

        $approval = Approval::with('spl')->where('status', '2')->get();
        $waiting_spv = DB::table('t_approval')
            ->where('status', '5')
            ->count();

        $waiting_head = DB::table('t_approval')
            ->where('status', '6')
            ->count();

        $pengajuan_terakhir = DB::table('t_spl')
            ->join('t_approval', 't_spl.id', '=', 't_approval.spl_id')
            ->join('t_detail_spl', 't_spl.id', '=', 't_detail_spl.spl_id')
            ->join('t_karyawan', 't_detail_spl.karyawan_id', '=', 't_karyawan.id')
            ->select('t_spl.id_spl', 't_spl.kode_proyek', 't_approval.status')
            ->where('t_karyawan.nik_karyawan', auth()->user()->karyawan->nik_karyawan)
            ->get();

        $total = $detailspl->count();
        $total_approval = $approval->count();
        return view('page.labour.index', [
            'title' => 'Labour'
        ], compact('total', 'total_approval', 'waiting_spv', 'waiting_head', 'pengajuan_terakhir'));
    }

    public function getDashboard()
    {
        $month = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];

        for ($i = 0; $i < count($month); $i++) {
            $total[$i] = DB::table('t_spl')
                ->join('t_detail_spl', 't_spl.id', '=', 't_detail_spl.spl_id')
                ->join('t_karyawan', 't_detail_spl.karyawan_id', '=', 't_karyawan.id')
                ->whereMonth('t_spl.created_at', $month[$i])
                ->whereYear('t_spl.created_at', Carbon::now()->year)
                ->where('t_karyawan.nik_karyawan', auth()->user()->karyawan->nik_karyawan)
                ->select('t_karyawan.nik_karyawan')
                ->count();
        }
        $id_karaywan = auth()->user()->karyawan->nik_karyawan;

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
            'karyawan' => $id_karaywan
        ]);
    }
}
