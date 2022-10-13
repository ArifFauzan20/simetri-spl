<?php

namespace App\Http\Controllers\Koordinator;

use App\Http\Controllers\Controller;
use App\Models\Approval;
use App\Models\DetailSpl;
use App\Models\Spl;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use function PHPUnit\Framework\isNull;

class ApprovalController extends Controller
{
    // middleware protech page if not login or not role koordinator
    public function __construct()
    {
        $this->middleware('auth');
    }

    // index page koordinator
    public function index($id)
    {
        $spl = Spl::find($id);
        $details = DetailSpl::where('spl_id', '=', $id)->latest()->get();
        $detailspl = DetailSpl::where('spl_id', '=', $id)->latest()->first();
        $approval = Approval::where('spl_id', '=', $id)->latest()->first();

        // check if employee on detail spl is null
        if ($details->count() == 0) {
            alert()->error('Data karyawan belum dimasukkan');
            return redirect()->route('koordinator.data-pengajuan');
        }

        return view('page.koordinator.pengajuan-lembur.confirm', [
            'title' => 'Konfirmasi Pengajuan Lembur',
            'header' => 'Konfirmasi Pengajuan Lembur'
        ], compact('spl', 'details', 'detailspl', 'approval'));
    }

    // function for confirm pengajuan lembur
    public function confirm(Request $request)
    {
        $approvals = Approval::all();
        $approval = Approval::find($request->approval_id);
        // check if approval is null
        if ($approvals->count() == 0) {
            try {
                $save_approval = new Approval;
                $save_approval->spl_id = $request->spl_id;
                $save_approval->status = '5'; // status 5 = waiting for approval spv
                $save_approval->kode_proyek = $request->kode_proyek;
                $save_approval->tgl_pengajuan = Carbon::parse($request->tgl_pengajuan);
                $save_approval->end_date = Carbon::parse($request->end_date);
                $save_approval->updated_by = auth()->user()->karyawan->nama_karyawan;
                $save_approval->save();

                // send notification to security
                $http = Http::post('http://192.168.1.99:8080/simetri-api-local/api/local/send-email-security', [
                    'spl_id' => $request->id_spl,
                ]);

                return redirect()->route('koordinator.data-pengajuan')->with('toast_success', 'Pengajuan Lembur Berhasil Dikirim');
            } catch (\Throwable $th) {
                return redirect()->route('koordinator.data-pengajuan')->with('toast_error', $th->getMessage());
            }
        }

        // check if approvals is not null
        if ($approvals->count() > 0) {
            // check if approval is null
            if (is_null($approval)) {
                try {
                    $save_approval = new Approval;
                    $save_approval->spl_id = $request->spl_id;
                    $save_approval->status = '5'; // status 5 = waiting for approval spv
                    $save_approval->kode_proyek = $request->kode_proyek;
                    $save_approval->tgl_pengajuan = Carbon::parse($request->tgl_pengajuan);
                    $save_approval->end_date = Carbon::parse($request->end_date);
                    $save_approval->updated_by = auth()->user()->karyawan->nama_karyawan;
                    $save_approval->save();

                    // send notification to security
                    $http = Http::post('http://192.168.1.99:8080/simetri-api-local/api/local/send-email-security', [
                        'spl_id' => $request->id_spl,
                    ]);

                    return redirect()->route('koordinator.data-pengajuan')->with('toast_success', 'Pengajuan Lembur Berhasil Dikirim');
                } catch (\Throwable $th) {
                    return redirect()->route('koordinator.data-pengajuan')->with('toast_error', $th->getMessage());
                }
            }

            // check if approval status is rejected by spv
            if ($approval->status == '3') {
                // update approval status
                try {
                    $approval->update([
                        'status' => '5', // status 5 = waiting for approval spv
                        'kode_proyek' => $request->kode_proyek,
                        'tgl_pengajuan' =>  Carbon::parse($request->tgl_pengajuan),
                        'end_date' =>  Carbon::parse($request->end_date),
                        'updated_by' => auth()->user()->karyawan->nama_karyawan,
                        'keterangan' => $request->keterangan,
                    ]);
                    return redirect()->route('koordinator.data-pengajuan')->with('toast_success', 'Pengajuan Lembur Berhasil Dikirim');
                } catch (\Throwable $th) {
                    return redirect()->route('koordinator.data-pengajuan')->with('toast_error', $th->getMessage());
                }
            }

            // check if approval status is rejected by head
            if ($approval->status == '4') {
                // update approval status
                try {
                    $approval->update([
                        'status' => '6', // status 6 = waiting for approval head
                        'kode_proyek' => $request->kode_proyek,
                        'tgl_pengajuan' =>  Carbon::parse($request->tgl_pengajuan),
                        'end_date' =>  Carbon::parse($request->end_date),
                        'updated_by' => auth()->user()->karyawan->nama_karyawan,
                        'keterangan' => $request->keterangan,
                    ]);
                    return redirect()->route('koordinator.data-pengajuan')->with('toast_success', 'Pengajuan Lembur Berhasil Dikirim');
                } catch (\Throwable $th) {
                    return redirect()->route('koordinator.data-pengajuan')->with('toast_error', $th->getMessage());
                }
            }
        }

        // check if approval null
        if ($approvals->count() == 0) {
            // save approval
            try {
                $approval = new Approval;
                $approval->spl_id = $request->spl_id;
                $approval->status = '5'; // status 5 = waiting for approval spv
                $approval->kode_proyek = $request->kode_proyek;
                $approval->tgl_pengajuan =  Carbon::parse($request->tgl_pengajuan);
                $approval->end_date =  Carbon::parse($request->end_dae);
                $approval->updated_by = auth()->user()->karyawan->nama_karyawan;
                $approval->save();

                // send notification to security
                $http = Http::post('http://192.168.1.99:8080/simetri-api-local/api/local/send-email-security', [
                    'spl_id' => $request->id_spl,
                ]);

                return redirect()->route('koordinator.data-pengajuan')->with('toast_success', 'Pengajuan Lembur Berhasil Dikirim');
            } catch (\Throwable $th) {
                return redirect()->route('koordinator.data-pengajuan')->with('toast_error', 'Pengajuan Lembur Gagal Dikirim');
            }
        } else if ($approval->status == '3' && $approval->tgl_approval_spv == null) { //check if approval status is rejected by spv
            try {
                // update approval status
                $approval->update([
                    'status' => '5', // status 5 = waiting for approval spv
                    'kode_proyek' => $request->kode_proyek,
                    'tgl_pengajuan' =>  Carbon::parse($request->tgl_pengajuan),
                    'end_date' =>  Carbon::parse($request->end_dae),
                    'updated_by' => auth()->user()->karyawan->nama_karyawan,
                    'keterangan' => $request->keterangan,
                ]);
                return redirect()->route('koordinator.data-pengajuan')->with('toast_success', 'Pengajuan Lembur Berhasil Dikirim');
            } catch (\Throwable $th) {
                return redirect()->route('koordinator.data-pengajuan')->with('toast_error', 'Pengajuan Lembur Gagal Dikirim');
            }
        } else if ($approval->status == '3' && $approval->tgl_approval_spv != null && $approval->tgl_approval_manager == null) { //check if approval status is rejected by head
            // update approval status
            try {
                $approval->update([
                    'status' => '6', // status 6 = waiting for approval head
                    'kode_proyek' => $request->kode_proyek,
                    'tgl_pengajuan' =>  Carbon::parse($request->tgl_pengajuan),
                    'end_date' =>  Carbon::parse($request->end_dae),
                    'updated_by' => auth()->user()->karyawan->nama_karyawan,
                    'keterangan' => $request->keterangan,
                ]);
                return redirect()->route('koordinator.data-pengajuan')->with('toast_success', 'Pengajuan Lembur Berhasil Dikirim');
            } catch (\Throwable $th) {
                return redirect()->route('koordinator.data-pengajuan')->with('toast_error', 'Pengajuan Lembur Gagal Dikirim');
            }
        }
    }
}
