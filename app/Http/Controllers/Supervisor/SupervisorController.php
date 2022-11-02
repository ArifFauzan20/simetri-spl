<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Approval;
use App\Models\Bagian;
use App\Models\DetailSpl;
use App\Models\Spl;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Else_;
use RealRashid\SweetAlert\Facades\Alert;

class SupervisorController extends Controller
{
    // middleware protech page if not login or not role supervisor
    public function __construct()
    {
        $this->middleware('auth');
    }

    // index page supervisor
    public function index()
    {
        $detailspl = DB::table('t_spl')
            ->join('t_detail_spl', 't_spl.id', '=', 't_detail_spl.spl_id')
            ->join('t_karyawan', 't_detail_spl.karyawan_id', '=', 't_karyawan.id')
            ->join('r_bagian', 't_karyawan.bagian_id', '=', 'r_bagian.id')
            ->select('t_spl.id_spl')
            ->where('r_bagian.nama_bagian', auth()->user()->karyawan->bagian->nama_bagian)
            ->orderBy('t_spl.id_spl', 'desc')
            ->distinct()
            ->get();
        $approval = Approval::with('spl')
            ->where('updated_by', 'KABUL MUKTIONO')
            ->where('status', '2')->get();
        // $waiting_spv = DB::table('t_approval')
        //     ->join('t_spl', 't_approval.spl_id', '=', 't_spl.id')
        //     ->where('t_approval.status', '5')
        //     ->where('t_spl.updated_by_bagian', auth()->user()->karyawan->bagian->bagian_id)
        //     ->count();
        if(auth()->user()->karyawan->bagian->id == 26) {
            $waiting_spv = DB::table('t_approval')
                    ->join('t_spl', 't_approval.spl_id', '=', 't_spl.id')
                    ->where(
                        [
                            ['t_approval.status', '5'],
                            ['t_spl.updated_by_bagian', '26'], //DL QC
                        ]
                    )
                    ->count();
        } elseif (auth()->user()->karyawan->bagian->id == 16){
            $waiting_spv = DB::table('t_approval')
                    ->join('t_spl', 't_approval.spl_id', '=', 't_spl.id')
                    ->where(
                        [
                            ['t_approval.status', '5'],
                            ['t_spl.updated_by_bagian', '16'], //SECURITY
                        ]
                    )
                    ->count();
        } elseif (auth()->user()->karyawan->bagian->id == 16){
            $waiting_spv = DB::table('t_approval')
                    ->join('t_spl', 't_approval.spl_id', '=', 't_spl.id')
                    ->where(
                        [
                            ['t_approval.status', '5'],
                            ['t_spl.updated_by_bagian', '12'], //DL LISTRIK
                        ]
                    )
                    ->count();
        } elseif (auth()->user()->karyawan->bagian->id == 5){
            $waiting_spv = DB::table('t_approval')
                    ->join('t_spl', 't_approval.spl_id', '=', 't_spl.id')
                    ->where(
                        [
                            ['t_approval.status', '5'],
                            ['t_spl.updated_by_bagian', '5'], //FINANCE
                        ]
                    )
                    ->count();
        } elseif (auth()->user()->karyawan->bagian->id == 18){
            $waiting_spv = DB::table('t_approval')
                    ->join('t_spl', 't_approval.spl_id', '=', 't_spl.id')
                    ->where(
                        [
                            ['t_approval.status', '5'],
                            ['t_spl.updated_by_bagian', '18'], //TECHNICAL ENGINEERING
                        ]
                    )
                    ->count();
        } elseif (auth()->user()->karyawan->bagian->id == 25){
            $waiting_spv = DB::table('t_approval')
                    ->join('t_spl', 't_approval.spl_id', '=', 't_spl.id')
                    ->where(
                        [
                            ['t_approval.status', '5'],
                            ['t_spl.updated_by_bagian', '25'], //TEKNISI TUGAS LUAR
                        ]
                    )
                    ->count();
        } elseif (auth()->user()->karyawan->bagian->id == 17){
            $waiting_spv = DB::table('t_approval')
                    ->join('t_spl', 't_approval.spl_id', '=', 't_spl.id')
                    ->where(
                        [
                            ['t_approval.status', '5'],
                            ['t_spl.updated_by_bagian', '17'], //DESIGN EGINEERING
                        ]
                    )
                    ->count();
        } elseif (auth()->user()->karyawan->bagian->id == 2){
            $waiting_spv = DB::table('t_approval')
                    ->join('t_spl', 't_approval.spl_id', '=', 't_spl.id')
                    ->where(
                        [
                            ['t_approval.status', '5'],
                            ['t_spl.updated_by_bagian', '2'], //PPIC
                        ]
                    )
                    ->count();
        } elseif (auth()->user()->karyawan->bagian->id == 27){
            $waiting_spv = DB::table('t_approval')
                    ->join('t_spl', 't_approval.spl_id', '=', 't_spl.id')
                    ->where(
                        [
                            ['t_approval.status', '5'],
                            ['t_spl.updated_by_bagian', '27'], //DL CAT
                        ]
                    )
                    ->count();
        } elseif (auth()->user()->karyawan->bagian->id == 10){
            $waiting_spv_mekanik = DB::table('t_approval')
                    ->join('t_spl', 't_approval.spl_id', '=', 't_spl.id')
                    ->where(
                        [
                            ['t_approval.status', '5'],
                            ['t_spl.updated_by_bagian', '10'], //DL MEKANIK
                        ]
                    )
                    ->count();
            $waiting_spv_elektromekanik = DB::table('t_approval')
                    ->join('t_spl', 't_approval.spl_id', '=', 't_spl.id')
                    ->where(
                        [
                            ['t_approval.status', '5'],
                            ['t_spl.updated_by_bagian', '13'], //DL ELEKTROMEKANIK
                        ]
                    )
                    ->count();
            $waiting_spv = $waiting_spv_mekanik + $waiting_spv_elektromekanik;
        } elseif (auth()->user()->karyawan->bagian->id == 6){
            $waiting_spv = DB::table('t_approval')
                    ->join('t_spl', 't_approval.spl_id', '=', 't_spl.id')
                    ->where(
                        [
                            ['t_approval.status', '5'],
                            ['t_spl.updated_by_bagian', '6'], //WAREHOUSE
                        ]
                    )
                    ->count();
        } 

        $waiting_head = DB::table('t_approval')
            ->join('t_spl', 't_approval.spl_id', '=', 't_spl.id')
            ->where('status', '6')
            ->where('t_spl.updated_by_bagian', '26')
            ->count();

        $pengajuan_terakhir = DB::table('t_spl')
            ->join('t_approval', 't_spl.id', '=', 't_approval.spl_id')
            ->select('t_spl.id_spl', 't_spl.kode_proyek', 't_spl.updated_by')
            ->get();

        $total = $detailspl->count();
        $total_approval = $approval->count();
        return view('page.supervisor.index', [
            'title' => 'Supervisor'
        ], compact('total', 'total_approval', 'waiting_spv', 'waiting_head', 'pengajuan_terakhir'));
    }

    // function for show data spl
    public function showData()
    {
        if (auth()->user()->karyawan->bagian->id == 10) {
            $data_approval = DB::table('t_spl')
                ->select('t_spl.id', 't_spl.id_spl', 't_spl.kode_proyek', 't_spl.nama_proyek', 't_approval.status', 't_spl.tgl_pengajuan', 't_spl.keterangan', 't_detail_spl.updated_by',  't_spl.updated_by_bagian', 't_spl.tgl_lembur')
                ->join('t_detail_spl', 't_spl.id', '=', 't_detail_spl.spl_id')
                ->join('t_approval', 't_spl.id', '=', 't_approval.spl_id')
                ->where('t_spl.updated_by_bagian', auth()->user()->karyawan->bagian->id)
                ->orWhere('t_spl.updated_by_bagian', 13)
                ->groupBy('t_spl.id', 't_spl.id_spl', 't_spl.kode_proyek', 't_spl.nama_proyek', 't_approval.status', 't_spl.tgl_pengajuan', 't_spl.keterangan', 't_detail_spl.updated_by',  't_spl.updated_by_bagian', 't_spl.tgl_lembur')
                ->orderBy('t_spl.created_at', 'desc')
                ->get();
        } else {
            $data_approval = DB::table('t_spl')
                ->select('t_spl.id', 't_spl.id_spl', 't_spl.kode_proyek', 't_spl.nama_proyek', 't_approval.status', 't_spl.tgl_pengajuan', 't_spl.keterangan', 't_detail_spl.updated_by',  't_spl.updated_by_bagian', 't_spl.tgl_lembur')
                ->join('t_detail_spl', 't_spl.id', '=', 't_detail_spl.spl_id')
                ->join('t_approval', 't_spl.id', '=', 't_approval.spl_id')
                ->where('t_spl.updated_by_bagian', auth()->user()->karyawan->bagian->id)
                ->groupBy('t_spl.id', 't_spl.id_spl', 't_spl.kode_proyek', 't_spl.nama_proyek', 't_approval.status', 't_spl.tgl_pengajuan', 't_spl.keterangan', 't_detail_spl.updated_by',  't_spl.updated_by_bagian', 't_spl.tgl_lembur')
                ->orderBy('t_spl.created_at', 'desc')
                ->get();
        }

        $bagian = Bagian::all();

        return view('page.supervisor.data-pengajuan.index', [
            'title' => 'Data Pengajuan Lembur',
            'header' => 'Data Pengajuan Lembur'
        ], compact('data_approval', 'bagian'));
    }

    // function for show detail data spl
    public function detail($id)
    {
        $spl = Spl::find($id);
        $details = DetailSpl::with('karyawan', 'spl')->where('spl_id', '=', $spl->id)->get();
        $detail = DetailSpl::with('karyawan', 'spl')->where('spl_id', '=', $spl->id)->first();


        return view('.page.supervisor.data-pengajuan.detail', [
            'title' => 'Detail Pengajuan Lembur',
            'header' => 'Detail Pengajuan Lembur'
        ], compact('details', 'detail'));
    }

    // function for approve data spl
    public function approved(Request $request)
    {
        $approval = Approval::find($request->id);
        $approval->status = "6"; // status 6 = waiting head
        $approval->tgl_approval_spv = Carbon::now();
        $approval->keterangan = $request->keterangan;

        try {
            $approval->save();
            return redirect()->route('supervisor.data-pengajuan')->with('toast_success', 'Data pengajuan disetujui');
        } catch (\Throwable $th) {
            return redirect()->route('supervisor.data-pengajuan')->with('toast_error', $th->getMessage());
        }
    }

    // function for reject data spl
    public function rejected(Request $request)
    {
        $approval = Approval::find($request->id);
        $approval->status = "3"; // status rejected
        $approval->keterangan = $request->keterangan;

        try {
            $approval->save();
            return redirect()->route('supervisor.data-pengajuan')->with('toast_success', 'Data pengajuan ditolak');
        } catch (\Throwable $th) {
            return redirect()->route('supervisor.data-pengajuan')->with('toast_error', $th->getMessage());
        }
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
