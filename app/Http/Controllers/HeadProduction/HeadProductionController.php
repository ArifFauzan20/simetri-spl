<?php

namespace App\Http\Controllers\HeadProduction;

use App\Http\Controllers\Controller;
use App\Models\Approval;
use App\Models\Bagian;
use App\Models\DetailSpl;
use App\Models\Spl;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HeadProductionController extends Controller
{
    // middleware protech page if not login or not role head production
    public function __construct()
    {
        $this->middleware('auth');
    }

    // index page head production
    public function index()
    {

        if (auth()->user()->karyawan->bagian->id == 2) {
            $detailspl = DB::table('t_spl')
                ->select('t_spl.id', 't_spl.id_spl', 't_spl.kode_proyek', 't_spl.nama_proyek', 't_approval.status', 't_spl.tgl_pengajuan', 't_spl.keterangan', 't_detail_spl.updated_by',  't_spl.updated_by_bagian', 't_spl.updated_by_bagian', 't_approval.tgl_approval_manager', 't_spl.tgl_lembur')
                ->join('t_detail_spl', 't_spl.id', '=', 't_detail_spl.spl_id')
                ->join('t_approval', 't_spl.id', '=', 't_approval.spl_id')
                ->where('t_spl.updated_by_bagian', '6')
                ->orWhere('t_spl.updated_by_bagian', '2')
                ->groupBy('t_spl.id', 't_spl.id_spl', 't_spl.kode_proyek', 't_spl.nama_proyek', 't_approval.status', 't_spl.tgl_pengajuan', 't_spl.keterangan', 't_detail_spl.updated_by',  't_spl.updated_by_bagian', 't_approval.tgl_approval_manager', 't_spl.tgl_lembur')
                ->orderBy('t_approval.status', 'desc')
                ->orderBy('t_spl.id', 'desc')
                ->get();

            $approval_wherehouse = DB::table('t_approval')
                ->join('t_spl', 't_approval.spl_id', '=', 't_spl.id')
                ->where(
                    [
                        ['t_approval.status', '2'],
                        ['t_spl.updated_by_bagian', '6'],
                    ]
                )
                ->count();

            $approval_ppic = DB::table('t_approval')
                ->join('t_spl', 't_approval.spl_id', '=', 't_spl.id')
                ->where(
                    [
                        ['t_approval.status', '2'],
                        ['t_spl.updated_by_bagian', '2'],
                    ]
                )
                ->count();

            $waiting_spv_wherehouse = DB::table('t_approval')
                ->join('t_spl', 't_approval.spl_id', '=', 't_spl.id')
                ->where(
                    [
                        ['t_approval.status', '5'],
                        ['t_spl.updated_by_bagian', '6'], //Mekanik
                    ]
                )
                ->count();

            $waiting_spv_ppic = DB::table('t_approval')
                ->join('t_spl', 't_approval.spl_id', '=', 't_spl.id')
                ->where(
                    [
                        ['t_approval.status', '5'],
                        ['t_spl.updated_by_bagian', '2'], //Mekanik
                    ]
                )
                ->count();

            $waiting_spv = $waiting_spv_wherehouse + $waiting_spv_ppic;

            $waiting_head_wherehouse = DB::table('t_approval')
                ->join('t_spl', 't_approval.spl_id', '=', 't_spl.id')
                ->where(
                    [
                        ['t_approval.status', '6'],
                        ['t_spl.updated_by_bagian', '6'], //Mekanik
                    ]
                )
                ->count();

            $waiting_head_ppic = DB::table('t_approval')
                ->join('t_spl', 't_approval.spl_id', '=', 't_spl.id')
                ->where(
                    [
                        ['t_approval.status', '6'],
                        ['t_spl.updated_by_bagian', '2'], //Mekanik
                    ]
                )
                ->count();

            $waiting_head = $waiting_head_wherehouse + $waiting_head_ppic;

            $pengajuan_terakhir = DB::table('t_spl')
                ->join('t_approval', 't_spl.id', '=', 't_approval.spl_id')
                ->select('t_spl.id_spl', 't_spl.kode_proyek', 't_spl.updated_by')
                ->where('t_spl.updated_by_bagian', '6')
                ->orWhere('t_spl.updated_by_bagian', '2')
                ->get();

            $total = $detailspl->count();
            $total_approval = $approval_wherehouse + $approval_ppic;
            return view('page.headproduction.index', [
                'title' => 'Head Production'
            ], compact('total', 'total_approval', 'waiting_spv', 'waiting_head', 'pengajuan_terakhir'));
        }

        if (auth()->user()->karyawan->bagian->id == 8) {
            $detailspl = DB::table('t_spl')
                ->select('t_spl.id', 't_spl.id_spl', 't_spl.kode_proyek', 't_spl.nama_proyek', 't_approval.status', 't_spl.tgl_pengajuan', 't_spl.keterangan', 't_detail_spl.updated_by',  't_spl.updated_by_bagian', 't_spl.updated_by_bagian', 't_approval.tgl_approval_manager', 't_spl.tgl_lembur')
                ->join('t_detail_spl', 't_spl.id', '=', 't_detail_spl.spl_id')
                ->join('t_approval', 't_spl.id', '=', 't_approval.spl_id')
                ->where('t_spl.updated_by_bagian', '10')
                ->orWhere('t_spl.updated_by_bagian', '12')
                ->orWhere('t_spl.updated_by_bagian', '13')
                ->orWhere('t_spl.updated_by_bagian', '27')
                ->orWhere('t_spl.updated_by_bagian', '8')
                ->groupBy('t_spl.id', 't_spl.id_spl', 't_spl.kode_proyek', 't_spl.nama_proyek', 't_approval.status', 't_spl.tgl_pengajuan', 't_spl.keterangan', 't_detail_spl.updated_by',  't_spl.updated_by_bagian', 't_approval.tgl_approval_manager', 't_spl.tgl_lembur')
                ->orderBy('t_approval.status', 'desc')
                ->orderBy('t_spl.id', 'desc')
                ->get();

            $approval_mekanik = DB::table('t_approval')
                ->join('t_spl', 't_approval.spl_id', '=', 't_spl.id')
                ->where(
                    [
                        ['t_approval.status', '2'],
                        ['t_spl.updated_by_bagian', '10'],
                    ]
                )
                ->count();

            $approval_listrik = DB::table('t_approval')
                ->join('t_spl', 't_approval.spl_id', '=', 't_spl.id')
                ->where(
                    [
                        ['t_approval.status', '2'],
                        ['t_spl.updated_by_bagian', '12'],
                    ]
                )
                ->count();

            $approval_elektromekanik = DB::table('t_approval')
                ->join('t_spl', 't_approval.spl_id', '=', 't_spl.id')
                ->where(
                    [
                        ['t_approval.status', '2'],
                        ['t_spl.updated_by_bagian', '13'],
                    ]
                )
                ->count();

            $approval_cat = DB::table('t_approval')
                ->join('t_spl', 't_approval.spl_id', '=', 't_spl.id')
                ->where(
                    [
                        ['t_approval.status', '2'],
                        ['t_spl.updated_by_bagian', '27'],
                    ]
                )
                ->count();

            $approval_wo = DB::table('t_approval')
                ->join('t_spl', 't_approval.spl_id', '=', 't_spl.id')
                ->where(
                    [
                        ['t_approval.status', '2'],
                        ['t_spl.updated_by_bagian', '8'],
                    ]
                )
                ->count();

            $waiting_spv_mekanik = DB::table('t_approval')
                ->join('t_spl', 't_approval.spl_id', '=', 't_spl.id')
                ->where(
                    [
                        ['t_approval.status', '5'],
                        ['t_spl.updated_by_bagian', '10'], //Mekanik
                    ]
                )
                ->count();

            $waiting_spv_listrik = DB::table('t_approval')
                ->join('t_spl', 't_approval.spl_id', '=', 't_spl.id')
                ->where(
                    [
                        ['t_approval.status', '5'],
                        ['t_spl.updated_by_bagian', '12'], //Listrik
                    ]
                )
                ->count();

            $waiting_spv_elektromekanik = DB::table('t_approval')
                ->join('t_spl', 't_approval.spl_id', '=', 't_spl.id')
                ->where(
                    [
                        ['t_approval.status', '5'],
                        ['t_spl.updated_by_bagian', '13'], //Elektromekanik
                    ]
                )
                ->count();

            $waiting_spv_cat = DB::table('t_approval')
                ->join('t_spl', 't_approval.spl_id', '=', 't_spl.id')
                ->where(
                    [
                        ['t_approval.status', '5'],
                        ['t_spl.updated_by_bagian', '27'], //cat
                    ]
                )
                ->count();

            $waiting_spv_wo = DB::table('t_approval')
                ->join('t_spl', 't_approval.spl_id', '=', 't_spl.id')
                ->where(
                    [
                        ['t_approval.status', '5'],
                        ['t_spl.updated_by_bagian', '8'], //wo
                    ]
                )
                ->count();

            $waiting_spv = $waiting_spv_mekanik + $waiting_spv_listrik + $waiting_spv_elektromekanik + $waiting_spv_cat + $waiting_spv_wo;

            $waiting_head_mekanik = DB::table('t_approval')
                ->join('t_spl', 't_approval.spl_id', '=', 't_spl.id')
                ->where(
                    [
                        ['t_approval.status', '6'],
                        ['t_spl.updated_by_bagian', '10'], //Mekanik
                    ]
                )
                ->count();

            $waiting_head_listrik = DB::table('t_approval')
                ->join('t_spl', 't_approval.spl_id', '=', 't_spl.id')
                ->where(
                    [
                        ['t_approval.status', '6'],
                        ['t_spl.updated_by_bagian', '12'], //Listrik
                    ]
                )
                ->count();

            $waiting_head_elektromekanik = DB::table('t_approval')
                ->join('t_spl', 't_approval.spl_id', '=', 't_spl.id')
                ->where(
                    [
                        ['t_approval.status', '6'],
                        ['t_spl.updated_by_bagian', '13'], //Elektromekanik
                    ]
                )
                ->count();

            $waiting_head_cat = DB::table('t_approval')
                ->join('t_spl', 't_approval.spl_id', '=', 't_spl.id')
                ->where(
                    [
                        ['t_approval.status', '6'],
                        ['t_spl.updated_by_bagian', '27'], //cat
                    ]
                )
                ->count();

            $waiting_head_wo = DB::table('t_approval')
                ->join('t_spl', 't_approval.spl_id', '=', 't_spl.id')
                ->where(
                    [
                        ['t_approval.status', '6'],
                        ['t_spl.updated_by_bagian', '8'], //wo
                    ]
                )
                ->count();

            $waiting_head = $waiting_head_mekanik + $waiting_head_listrik + $waiting_head_elektromekanik + $waiting_head_cat + $waiting_head_wo;

            $pengajuan_terakhir = DB::table('t_spl')
                ->join('t_approval', 't_spl.id', '=', 't_approval.spl_id')
                ->select('t_spl.id_spl', 't_spl.kode_proyek', 't_spl.updated_by')
                ->where('t_spl.updated_by_bagian', '10')
                ->orWhere('t_spl.updated_by_bagian', '12')
                ->orWhere('t_spl.updated_by_bagian', '13')
                ->orWhere('t_spl.updated_by_bagian', '27')
                ->orWhere('t_spl.updated_by_bagian', '8')
                ->get();

            $total = $detailspl->count();
            $total_approval = $approval_mekanik + $approval_listrik + $approval_elektromekanik + $approval_cat + $approval_wo;
            return view('page.headproduction.index', [
                'title' => 'Head Productions'
            ], compact('total', 'total_approval', 'waiting_spv', 'waiting_head', 'pengajuan_terakhir'));
        }

        if (auth()->user()->karyawan->bagian->id != 2 && auth()->user()->karyawan->bagian->id != 8) {
            $detailspl = DB::table('t_spl')
                ->select('t_spl.id', 't_spl.id_spl', 't_spl.kode_proyek', 't_spl.nama_proyek', 't_approval.status', 't_spl.tgl_pengajuan', 't_spl.keterangan', 't_detail_spl.updated_by',  't_spl.updated_by_bagian', 't_spl.updated_by_bagian', 't_approval.tgl_approval_manager', 't_spl.tgl_lembur')
                ->join('t_detail_spl', 't_spl.id', '=', 't_detail_spl.spl_id')
                ->join('t_approval', 't_spl.id', '=', 't_approval.spl_id')
                ->whereNot('t_spl.updated_by_bagian', '6')
                ->whereNot('t_spl.updated_by_bagian', '2')
                ->whereNot('t_spl.updated_by_bagian', '10')
                ->whereNot('t_spl.updated_by_bagian', '12')
                ->whereNot('t_spl.updated_by_bagian', '13')
                ->whereNot('t_spl.updated_by_bagian', '27')
                ->whereNot('t_spl.updated_by_bagian', '8')
                ->groupBy(
                    't_spl.id',
                    't_spl.id_spl',
                    't_spl.kode_proyek',
                    't_spl.nama_proyek',
                    't_approval.status',
                    't_spl.tgl_pengajuan',
                    't_spl.keterangan',
                    't_detail_spl.updated_by',
                    't_spl.updated_by_bagian',
                    't_approval.tgl_approval_manager',
                    't_spl.tgl_lembur'
                )
                ->orderBy('t_approval.status', 'desc')
                ->orderBy('t_spl.id', 'desc')
                ->get();

            $approval = DB::table('t_approval')
                ->join('t_spl', 't_approval.spl_id', '=', 't_spl.id')
                ->where('status', '2')
                ->whereNot('t_spl.updated_by_bagian', '6')
                ->whereNot('t_spl.updated_by_bagian', '2')
                ->whereNot('t_spl.updated_by_bagian', '10')
                ->whereNot('t_spl.updated_by_bagian', '12')
                ->whereNot('t_spl.updated_by_bagian', '13')
                ->whereNot('t_spl.updated_by_bagian', '27')
                ->whereNot('t_spl.updated_by_bagian', '8')
                ->count();

            $waiting_spv = DB::table('t_approval')
                ->join('t_spl', 't_approval.spl_id', '=', 't_spl.id')
                ->where('status', '5')
                ->whereNot('t_spl.updated_by_bagian', '6')
                ->whereNot('t_spl.updated_by_bagian', '2')
                ->whereNot('t_spl.updated_by_bagian', '10')
                ->whereNot('t_spl.updated_by_bagian', '12')
                ->whereNot('t_spl.updated_by_bagian', '13')
                ->whereNot('t_spl.updated_by_bagian', '27')
                ->whereNot('t_spl.updated_by_bagian', '8')
                ->count();

            $waiting_head = DB::table('t_approval')
                ->join('t_spl', 't_approval.spl_id', '=', 't_spl.id')
                ->where('status', '6')
                ->whereNot('t_spl.updated_by_bagian', '6')
                ->whereNot('t_spl.updated_by_bagian', '2')
                ->whereNot('t_spl.updated_by_bagian', '10')
                ->whereNot('t_spl.updated_by_bagian', '12')
                ->whereNot('t_spl.updated_by_bagian', '13')
                ->whereNot('t_spl.updated_by_bagian', '27')
                ->whereNot('t_spl.updated_by_bagian', '8')
                ->count();

            $pengajuan_terakhir = DB::table('t_spl')
                ->join('t_approval', 't_spl.id', '=', 't_approval.spl_id')
                ->select('t_spl.id_spl', 't_spl.kode_proyek', 't_spl.updated_by')
                ->whereNot('t_spl.updated_by_bagian', '6')
                ->whereNot('t_spl.updated_by_bagian', '2')
                ->whereNot('t_spl.updated_by_bagian', '10')
                ->whereNot('t_spl.updated_by_bagian', '12')
                ->whereNot('t_spl.updated_by_bagian', '13')
                ->whereNot('t_spl.updated_by_bagian', '27')
                ->whereNot('t_spl.updated_by_bagian', '8')
                ->get();

            $total = $detailspl->count();
            $total_approval = $approval;
            return view('page.headproduction.index', [
                'title' => 'Head Productions'
            ], compact('total', 'total_approval', 'waiting_spv', 'waiting_head', 'pengajuan_terakhir'));
        }
    }

    // show all data function
    public function showData(Request $request)
    {
        $updated_by = $request->updated_by; 
        $sdate = $request->sdate; 
        // $edate = $request->sdate;

        $bagian = Bagian::all();

        // show data by bagian PPIC
        if (auth()->user()->karyawan->bagian->id == 2) {
            $data_approval = DB::table('t_spl')
                ->select('t_spl.id', 't_spl.id_spl', 't_spl.kode_proyek', 't_spl.nama_proyek', 't_approval.status', 't_spl.tgl_pengajuan', 't_spl.keterangan', 't_detail_spl.updated_by', 't_spl.updated_by_bagian', 't_approval.tgl_approval_manager', 't_spl.tgl_lembur','t_spl.updated_by')
                ->join('t_detail_spl', 't_spl.id', '=', 't_detail_spl.spl_id')
                ->join('t_approval', 't_spl.id', '=', 't_approval.spl_id')
                ->where('t_spl.updated_by', 'like', '%'.$updated_by.'%')
                ->where('t_spl.tgl_lembur', 'like', '%'.$sdate.'%')
                ->where('t_spl.updated_by_bagian', '6')
                ->orWhere('t_spl.updated_by_bagian', '2')
                ->groupBy('t_spl.id', 't_spl.id_spl', 't_spl.kode_proyek', 't_spl.nama_proyek', 't_approval.status', 't_spl.tgl_pengajuan', 't_spl.keterangan', 't_detail_spl.updated_by',  't_spl.updated_by_bagian', 't_approval.tgl_approval_manager', 't_spl.tgl_lembur','t_spl.updated_by')
                ->orderBy('t_approval.status', 'desc')
                ->orderBy('t_spl.id', 'desc')
                ->get();
            return view('page.headproduction.data-pengajuan.index', [
                'title' => 'Data Pengajuan Lembur',
                'header' => 'Data Pengajuan Lembur'
            ], compact('data_approval', 'bagian'));
        }


        // show data by bagian WO / production
        // id 10, 12, 13, 27
        if (auth()->user()->karyawan->bagian->id == 8) {
            $data_approval = DB::table('t_spl')
                ->select('t_spl.id', 't_spl.id_spl', 't_spl.kode_proyek', 't_spl.nama_proyek', 't_approval.status', 't_spl.tgl_pengajuan', 't_spl.keterangan', 't_detail_spl.updated_by',  't_spl.updated_by_bagian', 't_approval.tgl_approval_manager', 't_spl.tgl_lembur', 't_spl.updated_by')
                ->join('t_detail_spl', 't_spl.id', '=', 't_detail_spl.spl_id')
                ->join('t_approval', 't_spl.id', '=', 't_approval.spl_id')
                ->where('t_spl.updated_by', 'like', '%'.$updated_by.'%')
                ->where('t_spl.tgl_lembur', 'like', '%'.$sdate.'%')
                // ->where('t_spl.updated_by_bagian', '10')
                // ->orWhere('t_spl.updated_by_bagian', '12')
                // ->orWhere('t_spl.updated_by_bagian', '13')
                // ->orWhere('t_spl.updated_by_bagian', '27')
                // ->orWhere('t_spl.updated_by_bagian', '8')
                ->whereNot('t_spl.updated_by_bagian', '6')
                ->whereNot('t_spl.updated_by_bagian', '16')
                ->whereNot('t_spl.updated_by_bagian', '5')
                ->whereNot('t_spl.updated_by_bagian', '2')
                ->whereNot('t_spl.updated_by_bagian', '25')
                ->whereNot('t_spl.updated_by_bagian', '17')
                ->groupBy('t_spl.id', 't_spl.id_spl', 't_spl.kode_proyek', 't_spl.nama_proyek', 't_approval.status', 't_spl.tgl_pengajuan', 't_spl.keterangan', 't_detail_spl.updated_by',  't_spl.updated_by_bagian', 't_approval.tgl_approval_manager', 't_spl.tgl_lembur', 't_spl.updated_by')
                ->orderBy('t_approval.status', 'desc')
                ->orderBy('t_spl.id', 'desc')
                ->get();
            return view('page.headproduction.data-pengajuan.index', [
                'title' => 'Data Pengajuan Lembur',
                'header' => 'Data Pengajuan Lembur'
            ], compact('data_approval', 'bagian'));
        }

        if (auth()->user()->karyawan->bagian->id != 2 && auth()->user()->karyawan->bagian->id != 8) {
            $data_approval = DB::table('t_spl')
                ->select('t_spl.id', 't_spl.id_spl', 't_spl.kode_proyek', 't_spl.nama_proyek', 't_approval.status', 't_spl.tgl_pengajuan', 't_spl.keterangan', 't_detail_spl.updated_by',  't_spl.updated_by_bagian', 't_approval.tgl_approval_manager', 't_spl.tgl_lembur','t_spl.updated_by')
                ->join('t_detail_spl', 't_spl.id', '=', 't_detail_spl.spl_id')
                ->join('t_approval', 't_spl.id', '=', 't_approval.spl_id')
                ->where('t_spl.updated_by', 'like', '%'.$updated_by.'%')
                ->where('t_spl.tgl_lembur', 'like', '%'.$sdate.'%')
                ->whereNot('t_spl.updated_by_bagian', '6')
                ->whereNot('t_spl.updated_by_bagian', '2')
                ->whereNot('t_spl.updated_by_bagian', '10')
                ->whereNot('t_spl.updated_by_bagian', '12')
                ->whereNot('t_spl.updated_by_bagian', '13')
                ->whereNot('t_spl.updated_by_bagian', '27')
                ->whereNot('t_spl.updated_by_bagian', '8')
                ->whereNot('t_spl.updated_by_bagian', '5')
                ->groupBy('t_spl.id', 't_spl.id_spl', 't_spl.kode_proyek', 't_spl.nama_proyek', 't_approval.status', 't_spl.tgl_pengajuan', 't_spl.keterangan', 't_detail_spl.updated_by',  't_spl.updated_by_bagian', 't_approval.tgl_approval_manager', 't_spl.tgl_lembur','t_spl.updated_by')
                ->orderBy('t_approval.status', 'desc')
                ->orderBy('t_spl.id', 'desc')
                ->get();
            return view('page.headproduction.data-pengajuan.index', [
                'title' => 'Data Pengajuan Lembur',
                'header' => 'Data Pengajuan Lembur'
            ], compact('data_approval', 'bagian'));
        }
    }
   

    // show detail data function
    public function detail($id)
    {
        $spl = Spl::find($id);
        $details = DetailSpl::with('karyawan', 'spl')->where('spl_id', '=', $spl->id)->get();
        $detail = DetailSpl::with('karyawan', 'spl')->where('spl_id', '=', $spl->id)->first();


        return view('page.headproduction.data-pengajuan.detail', [
            'title' => 'Detail Pengajuan Lembur',
            'header' => 'Detail Pengajuan Lembur'
        ], compact('details', 'detail'));
    }

    // function approve spl
    public function approved(Request $request)
    {
        $approval = Approval::find($request->id);
        $approval->status = "2"; // 2 = approved
        $approval->tgl_approval_manager = Carbon::now();
        $approval->keterangan = $request->keterangan;
        try {
            $approval->save();
            return redirect()->route('headproduction.data-pengajuan')->with('toast_success', 'Data Berhasil Di Approve');
        } catch (\Throwable $th) {
            return redirect()->route('headproduction.data-pengajuan')->with('toast_error', $th->getMessage());
        }
    }

    // function reject spl
    public function rejected(Request $request)
    {
        $approval = Approval::find($request->id);
        $approval->status = "4"; // 4 = rejected by head
        $approval->keterangan = $request->keterangan;

        try {
            $approval->save();
            return redirect()->route('headproduction.data-pengajuan')->with('toast_success', 'Data pengajuan ditolak');
        } catch (\Throwable $th) {
            return redirect()->route('headproduction.data-pengajuan')->with('toast_error', $th->getMessage());
        }
    }

    // function dashboard
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
