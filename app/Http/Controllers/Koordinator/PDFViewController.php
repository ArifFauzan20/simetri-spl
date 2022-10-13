<?php

namespace App\Http\Controllers\Koordinator;

use App\Http\Controllers\Controller;
use App\Models\DetailSpl;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use PDF;

class PDFViewController extends Controller
{
    // function preview pdf spl
    public function index($id)
    {
        $detail = DetailSpl::with('spl', 'karyawan')->where('spl_id', $id)->first();
        $title = "Laporan SPL";
        $count = DetailSpl::where('spl_id', $id)->count();
        $details = DetailSpl::with('spl', 'karyawan')
            ->where('spl_id', $id)->get();
        $supervisor = DB::table('t_user_login')
            ->select('t_user_login.id as user_id', 't_karyawan.*', 'r_bagian.*', 'r_role_user.*')
            ->join('t_karyawan', 't_user_login.karyawan_id', '=', 't_karyawan.id')
            ->join('r_bagian', 't_karyawan.bagian_id', '=', 'r_bagian.id')
            ->join('r_role_user', 't_user_login.role_id', '=', 'r_role_user.id')
            ->where('r_role_user.id', 2)
            ->where('r_bagian.id', auth()->user()->karyawan->bagian->id)
            ->get();

        $manager = DB::table('t_user_login')
            ->select('t_user_login.id as user_id', 't_karyawan.*', 'r_bagian.*')
            ->join('t_karyawan', 't_user_login.karyawan_id', '=', 't_karyawan.id')
            ->join('r_bagian', 't_karyawan.bagian_id', '=', 'r_bagian.id')
            ->join('r_role_user', 't_user_login.role_id', '=', 'r_role_user.id')
            ->where('r_role_user.id', 3)
            ->get();

        return view('page.koordinator.pdfview', compact('detail', 'title', 'count', 'details', 'supervisor', 'manager'));
    }

    // function download pdf spl
    public function getPDF($id)
    {
        $details = DetailSpl::with('spl', 'karyawan')->where('spl_id', $id)->get();
        $detail = DetailSpl::with('spl', 'karyawan')->where('spl_id', $id)->first();
        $supervisor = DB::table('t_user_login')
            ->select('t_user_login.id as user_id', 't_karyawan.*')
            ->join('t_karyawan', 't_user_login.karyawan_id', '=', 't_karyawan.id')
            ->join('r_bagian', 't_karyawan.bagian_id', '=', 'r_bagian.id')
            ->join('r_role_user', 't_user_login.role_id', '=', 'r_role_user.id')
            ->where('r_role_user.id', 2)
            ->where('r_bagian.id', auth()->user()->karyawan->bagian->id)
            ->get();

        $manager = DB::table('t_user_login')
            ->select('t_user_login.id as user_id', 't_karyawan.*')
            ->join('t_karyawan', 't_user_login.karyawan_id', '=', 't_karyawan.id')
            ->join('r_bagian', 't_karyawan.bagian_id', '=', 'r_bagian.id')
            ->join('r_role_user', 't_user_login.role_id', '=', 'r_role_user.id')
            ->where('r_role_user.id', 3)
            ->where('r_bagian.id', auth()->user()->karyawan->bagian->id)
            ->get();

        $date = Carbon::parse($details[0]->spl->tgl_lembur)->isoFormat('D MMMM Y');
        $stime = Carbon::parse($details[0]->spl->start_jam)->isoFormat('HH:mm');
        $etime = Carbon::parse($details[0]->spl->end_jam)->isoFormat('HH:mm');
        $bagian =  $details[0]->karyawan->bagian->nama_bagian;
        $count = count($details);

        $pdf = PDF::loadView('page.koordinator.pdfexport', compact('details', 'date', 'stime', 'etime', 'bagian', 'count', 'supervisor', 'manager'));
        $pdf->setOption('enable-local-file-access', true);
        $pdf->setOption('enable-javascript', true);
        $pdf->setOption('javascript-delay', 5000);
        $pdf->setOption('enable-smart-shrinking', true);
        $pdf->setOption('no-stop-slow-scripts', true);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream($details[0]->spl->id_spl . '.pdf');
    }
}
