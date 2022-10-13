<?php

namespace App\Http\Controllers\Koordinator;

use App\Http\Controllers\Controller;
use App\Models\Approval;
use App\Models\DetailSpl;
use App\Models\Spl;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KoordinatorController extends Controller
{
    // middleware protech page if not login or not role koordinator
    public function __construct()
    {
        $this->middleware('auth');
    }

    // index page koordinator
    public function index()
    {
        $detailspl = Spl::where('updated_by', auth()->user()->karyawan->nama_karyawan)->get();
        $approval = Approval::with('spl')->where('status', '2')->get();

        $waiting_spv = DB::table('t_approval')
            ->where('status', '5')
            ->count();

        $waiting_head = DB::table('t_approval')
            ->where('status', '6')
            ->count();

        $pengajuan_terakhir = Spl::with('approval')
            ->where('t_spl.updated_by', auth()->user()->karyawan->nama_karyawan)
            ->get();

        $total = $detailspl->count();
        $total_approval = $approval->count();

        return view('page.koordinator.index', [
            'title' => 'Dashboard',
            'header' => 'Dashboard'
        ], compact('total', 'total_approval', 'waiting_spv', 'waiting_head', 'pengajuan_terakhir'));
    }

    // get data dashboard
    public function getDashboard()
    {
        $month = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];

        for ($i = 0; $i < count($month); $i++) {
            $total[$i] = DB::table('t_spl')
                ->whereMonth('created_at', $month[$i])
                ->whereYear('created_at', Carbon::now()->year)
                ->where('updated_by', auth()->user()->karyawan->nama_karyawan)
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
