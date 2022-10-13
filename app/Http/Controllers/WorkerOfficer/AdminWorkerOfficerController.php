<?php

namespace App\Http\Controllers\WorkerOfficer;

use App\Http\Controllers\Controller;
use App\Models\Approval;
use App\Models\DetailSpl;
use App\Models\Spl;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminWorkerOfficerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
        return view('page.worker-officer.index', [
            'title' => 'Admin WO'
        ], compact('total', 'total_approval', 'waiting_spv', 'waiting_head', 'pengajuan_terakhir'));
    }
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
