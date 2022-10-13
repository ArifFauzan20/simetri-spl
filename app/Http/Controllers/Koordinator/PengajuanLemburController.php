<?php

namespace App\Http\Controllers\Koordinator;

use App\Http\Controllers\Controller;
use App\Models\Approval;
use App\Models\DetailSpl;
use App\Models\HariKerja;
use App\Models\HariLibur;
use App\Models\Karyawan;
use App\Models\Spl;
use App\Models\UangMakan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PengajuanLemburController extends Controller
{
    // middleware protech page if not login or not role koordinator
    public function __construct()
    {
        $this->middleware('auth');
    }

    // index page pengajuan lembur
    public function index()
    {
        $spls = Spl::with('approval')->where('updated_by', '=', auth()->user()->karyawan->nama_karyawan)->latest()->get();
        $detail = DetailSpl::get();

        return view('page.koordinator.pengajuan-lembur.index', [
            'title' => 'Pengajuan Lembur',
            'header' => 'Pengajuan Lembur'
        ], compact('spls', 'detail'));
    }

    // function for create pengajuan lembur
    public function create()
    {
        $spls = Spl::where('updated_by', '=', auth()->user()->karyawan->nama_karyawan)->latest()->get();
        $projects = Http::get('http://192.168.1.99:8080/simetri-api-local/api/local/projects')['data']; // get data project from api
        // $projects = Http::get('http://system.sinarmetrindo.co.id:18881/simetri-api-local/api/local/projects')['data']; // maintenance if not connect to local network
        // $projects = Http::get('http://127.0.0.1:8000/api/local/projects')['data']; // maintenance if not connect to local network
        return view('page.koordinator.pengajuan-lembur.create', [
            'title' => 'Pengajuan Lembur',
            'header' => 'Pengajuan Lembur'
        ], compact('spls', 'projects'));
    }

    // function for store pengajuan lembur
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_proyek_input' => 'required',
            'nama_proyek_input' => 'required',
            'id_jenis_hari' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'keterangan' => 'required',

        ], [
            'kode_proyek_input.required' => 'Kode Proyek harus diisi!',
            'nama_proyek_input.required' => 'Nama Proyek harus diisi!',
            'id_jenis_hari.required' => 'Jenis Hari harus diisi!',
            'start_date.required' => 'Start date harus diisi!',
            'end_date.required' => 'End date harus diisi!',
            'keterangan.required' => 'Keterangan harus diisi!',
        ]);

        // logic for get total hour
        $start_jam = Carbon::parse($request->start_date);
        $end_jam = Carbon::parse($request->end_date);
        $diff = $start_jam->diffInMinutes($end_jam);
        $diff_jam = number_format($diff / 60, 1);

        // logic for get data hari libur
        if ($request->id_jenis_hari == '0') {
            // if total hour more than 3 hour and holiday
            if ($diff_jam >= 3) {
                $istirahat = 1; // 1 jam istirahat
            } else {
                $istirahat = 0; // 0 jam istirahat
            }
        } else {
            // jika hari kerja
            // if total hour more than 3 hour and not holiday
            if ($diff_jam >= 3) {
                $istirahat = 0.5; // 30 menit istirahat
            } else {
                $istirahat = 0; // 0 jam istirahat
            }
        }

        $spl = new Spl;
        $spl->id_spl = IdGenerator::generate(['table' => 't_spl', 'field' => 'id_spl', 'length' => 8, 'prefix' => 'SPL-']); // generate unique id spl
        $spl->kode_proyek = $request->kode_proyek_input;
        $spl->nama_proyek = $request->nama_proyek_input;
        $spl->keterangan = $request->keterangan;
        $spl->id_jenis_hari = $request->id_jenis_hari;
        $spl->tgl_lembur = Carbon::parse($request->start_date);
        $spl->end_date = Carbon::parse($request->end_date);
        $spl->start_jam = Carbon::parse($request->start_date)->format('H:i');
        $spl->end_jam = Carbon::parse($request->end_date)->format('H:i');
        $spl->istirahat = $istirahat;
        $spl->tgl_pengajuan = Carbon::now()->format('Y-m-d');
        $spl->updated_by = auth()->user()->karyawan->nama_karyawan;
        $spl->updated_by_bagian = auth()->user()->karyawan->bagian->id;
        $spl->save();
        return redirect()->route('koordinator.buat-pengajuan-lembur')->with('toast_success', 'Data berhasil ditambahkan');
    }

    // function for edit pengajuan lembur
    public function edit($id)
    {
        $spl = Spl::find($id);
        $spls = Spl::where('updated_by', '=', auth()->user()->karyawan->nama_karyawan)->latest()->get();
        $projects = Http::get('http://192.168.1.99:8080/simetri-api-local/api/local/projects')['data']; // get data project from api
        // $projects = Http::get('http://system.sinarmetrindo.co.id:18881/simetri-api-local/api/local/projects')['data']; // maintenance if not connect to local network
        // $projects = Http::get('http://127.0.0.1:8000/api/local/projects')['data']; // maintenance if not connect to local network

        $start_jam = Carbon::parse($spl->start_jam)->format('H:i');
        $end_jam = Carbon::parse($spl->end_jam)->format('H:i');

        return view('page.koordinator.pengajuan-lembur.edit', [
            'title' => 'Pengajuan Lembur',
            'header' => 'Pengajuan Lembur'
        ], compact('spl', 'spls', 'projects', 'start_jam', 'end_jam'));
    }

    // function for update pengajuan lembur
    public function update(Request $request)
    {
        $validated = $request->validate([
            'kode_proyek_input' => 'required',
            'id_jenis_hari' => 'required',
            'tgl_lembur' => 'required',
            'end_date' => 'required',
        ], [
            'kode_proyek_input.required' => 'Kode Proyek harus diisi!',
            'id_jenis_hari.required' => 'Jenis Hari harus diisi!',
            'tgl_lembur.required' => 'Tanggal Lembur harus diisi!',
            'end_date.required' => 'End date harus diisi!',
        ]);

        // logic for get total hour
        $start_jam = Carbon::parse($request->tgl_lembur);
        $end_jam = Carbon::parse($request->end_date);
        $diff = $start_jam->diffInMinutes($end_jam);
        $diff_jam = number_format($diff / 60, 1);

        // logic for get data hari libur
        if ($request->id_jenis_hari == '0') {
            // if total hour more than 3 hour and holiday
            if ($diff_jam >= 3) {
                $istirahat = 1; // 1 jam istirahat
            } else {
                $istirahat = 0; // 0 jam istirahat
            }
        } else {
            // jika hari kerja
            // if total hour more than 3 hour and not holiday
            if ($diff_jam >= 3) {
                $istirahat = 0.5; // 30 menit istirahat
            } else {
                $istirahat = 0; // 0 jam istirahat
            }
        }

        try {
            Spl::where('id', $request->id)->update([
                'kode_proyek' => $request->kode_proyek_input,
                'nama_proyek' => $request->nama_proyek_input,
                'keterangan' => $request->keterangan,
                'id_jenis_hari' => $request->id_jenis_hari,
                'tgl_lembur' => Carbon::parse($request->tgl_lembur),
                'end_date' => Carbon::parse($request->end_date),
                'start_jam' => Carbon::parse($request->tgl_lembur)->format('H:i:s'),
                'end_jam' => Carbon::parse($request->end_date)->format('H:i:s'),
                'istirahat' => $istirahat,
                'updated_by' => auth()->user()->karyawan->nama_karyawan
            ]);

            return redirect()->route('koordinator.buat-pengajuan-lembur')->with('toast_success', 'Data berhasil diubah');
        } catch (\Throwable $th) {
            return redirect()->route('koordinator.buat-pengajuan-lembur')->with('toast_error', 'Data gagal diubah');
        }
    }

    // function for delete pengajuan lembur
    public function delete(Request $request)
    {
        $spl = Spl::find($request->id);
        $details = DetailSpl::where('spl_id', $request->id)->get();

        try {
            $spl->delete();
            // delete detail spl if spl deleted
            foreach ($details as $detail) {
                $detail->delete();
            }
            return redirect()->route('koordinator.buat-pengajuan-lembur')->with('toast_success', 'Data berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->route('koordinator.buat-pengajuan-lembur')->with('toast_error', 'Data gagal dihapus');
        }
    }

    // function for get detail pengajuan lembur
    public function detailPengajuan($id)
    {
        $spl = Spl::find($id);
        $details = DetailSpl::where('updated_by', '=', auth()->user()->karyawan->nama_karyawan)->where('spl_id', '=', $id)->latest()->get();
        $employees = Karyawan::with('bagian')->get();
        $approval = Approval::where('spl_id', '=', $id)->first();


        // logic for get total hour
        $start_date = Carbon::parse($spl->tgl_lembur);
        $end_date = Carbon::parse($spl->end_date);
        $diff = $start_date->diffInMinutes($end_date);
        $diff_jam = number_format($diff / 60, 1);
        $total = $diff_jam - $spl->istirahat;

        return view('page.koordinator.pengajuan-lembur.detail', [
            'title' => 'Pengajuan Lembur',
            'header' => 'Pengajuan Lembur',

        ], compact('spl', 'details', 'employees', 'approval', 'diff_jam', 'total'));
    }

    // function for add employee to detail pengajuan lembur
    public function addListEmployee(Request $request)
    {
        $spl = Spl::find($request->id);
        $poin_kerja = HariKerja::all();
        $poin_libur = HariLibur::all();
        $karyawan = Karyawan::find($request->karyawan_id);


        $validated = $request->validate([
            'nik_karyawan_input' => 'required',
            'karyawan_id' => 'required',
            'nama_karyawan' => 'required',
            'uang_makan' => 'required'
        ], [
            'nik_karyawan_input.required' => 'NIK Karyawan harus diisi!',
            'karyawan_id.required' => 'Karyawan harus diisi!',
            'nama_karyawan.required' => 'Nama Karyawan harus diisi!',
            'uang_makan.required' => 'Uang Makan harus diisi!'
        ]);

        // logic for get diff hour
        $start_jam = Carbon::parse($request->tgl_lembur); // start date request from form
        $end_jam = Carbon::parse($request->end_date); 
        $diff_jam = number_format($start_jam->diffInMinutes($end_jam) / 60, 1);

        $point = '';
        $istirahat = $spl->istirahat;
        // logic for get total hour
        $total_waktu = $diff_jam - $istirahat;

        // logic for set point workday
        switch ($spl->id_jenis_hari) {
            case 0:
                foreach ($poin_libur as $pk) {
                    if ($total_waktu == $pk->jam_lembur) {
                        $point = $pk->point;
                    }
                }
                break;

            default:
                foreach ($poin_kerja as $pk) {
                    if ($total_waktu == $pk->jam_lembur) {
                        $point = $pk->point;
                    }
                }
                break;
        }

        // logic for get tarif lembur
        $tarif_total_lembur = ((float)$point * (float)$karyawan->tarif_lembur) + $request->uang_makan;

        try {
            $detail_spl = new DetailSpl;
            $detail_spl->spl_id = $request->id;
            $detail_spl->karyawan_id = $request->karyawan_id;
            $detail_spl->lama_lembur = $total_waktu;
            $detail_spl->uang_makan = $request->uang_makan;
            $detail_spl->poin_lembur = $point;
            $detail_spl->tarif_total_lembur = $tarif_total_lembur;
            $detail_spl->updated_by = auth()->user()->karyawan->nama_karyawan;
            $detail_spl->save();

            // $http = Http::post('http://127.0.0.1:8000/api/local/spl', [
            //     'spl_id' => $request->id,
            //     'kode_proyek' => $spl->kode_proyek,
            //     'nama_proyek' => $spl->nama_proyek,
            //     'nik_karyawan' => $karyawan->nik_karyawan,
            //     'nama_karyawan' => $karyawan->nama_karyawan,
            //     'lama_lembur' => $total_waktu,
            //     'jenis_hari' => $spl->id_jenis_hari,
            //     'tgl_pengajuan' => $spl->tgl_pengajuan,
            //     'start_date' => $spl->tgl_lembur,
            //     'end_date' => $spl->end_date,
            //     'start_time' => $spl->start_jam,
            //     'end_time' => $spl->end_jam,
            //     'uang_makan' => $request->uang_makan,
            //     'total_tarif_lembur' => $tarif_total_lembur,
            //     'keterangan' => $spl->keterangan,
            // ]);

            // send data to api for prepare data for email notification
            $http = Http::post('http://192.168.1.99:8080/simetri-api-local/api/local/spl', [
                'spl_id' => $spl->id_spl,
                'kode_proyek' => $spl->kode_proyek,
                'nama_proyek' => $spl->nama_proyek,
                'nik_karyawan' => $karyawan->nik_karyawan,
                'nama_karyawan' => $karyawan->nama_karyawan,
                'lama_lembur' => $total_waktu,
                'jenis_hari' => $spl->id_jenis_hari,
                'tgl_pengajuan' => $spl->tgl_pengajuan,
                'start_date' => $spl->tgl_lembur,
                'end_date' => $spl->end_date,
                'start_time' => $spl->start_jam,
                'end_time' => $spl->end_jam,
                'uang_makan' => $request->uang_makan,
                'total_tarif_lembur' => $tarif_total_lembur,
                'keterangan' => $spl->keterangan,
            ]);

            // $http = Http::post('http://system.sinarmetrindo.co.id:18881/simetri-api-local/api/local/spl', [
            //     'spl_id' => $request->id,
            //     'kode_proyek' => $spl->kode_proyek,
            //     'nama_proyek' => $spl->nama_proyek,
            //     'nik_karyawan' => $karyawan->nik_karyawan,
            //     'nama_karyawan' => $karyawan->nama_karyawan,
            //     'lama_lembur' => $total_waktu,
            //     'jenis_hari' => $spl->id_jenis_hari,
            //     'tgl_pengajuan' => $spl->tgl_pengajuan,
            //     'start_date' => $spl->tgl_lembur,
            //     'end_date' => $spl->end_date,
            //     'start_time' => $spl->start_jam,
            //     'end_time' => $spl->end_jam,
            //     'uang_makan' => $request->uang_makan,
            //     'total_tarif_lembur' => $tarif_total_lembur,
            //     'keterangan' => $spl->keterangan,
            // ]);

            // dd($http->json());

            return redirect('/koordinator/data-pengajuan/detail-pengajuan/' . $spl->id)->with('toast_success', 'Data berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect('/koordinator/data-pengajuan/detail-pengajuan/' . $spl->id)->with('toast_error', $th->getMessage());
        }
    }

    // function for edit list employee
    public function editListEmployee($id, $detail_id)
    {
        $spl = Spl::find($id);
        $detail = DetailSpl::find($detail_id);
        $details = DetailSpl::where('updated_by', '=', auth()->user()->karyawan->nama_karyawan)->where('spl_id', '=', $id)->get();
        $employees = Karyawan::where('bagian_id', '=', auth()->user()->karyawan->bagian_id)->get();
        return view('page.koordinator.pengajuan-lembur.edit-list', [
            'title' => 'Pengajuan Lembur',
            'header' => 'Pengajuan Lembur'
        ], compact('spl', 'detail', 'employees', 'details'));
    }

    // function for update list employee
    public function updateListEmployee(Request $request)
    {
        $spl = Spl::find($request->id);
        $poin_kerja = HariKerja::all();
        $poin_libur = HariLibur::all();
        $karyawan = Karyawan::find($request->karyawan_id);

        $validated = $request->validate([
            'nik_karyawan' => 'required',
            'karyawan_id' => 'required',
            'nama_karyawan' => 'required',
            'uang_makan' => 'required'
        ], [
            'nik_karyawan.required' => 'NIK Karyawan harus diisi!',
            'karyawan_id.required' => 'Karyawan harus diisi!',
            'nama_karyawan.required' => 'Nama Karyawan harus diisi!',
            'uang_makan.required' => 'Uang Makan harus diisi!'
        ]);

        // get diff hours
        $start_jam = Carbon::parse($request->start_jam);
        $end_jam = Carbon::parse($request->end_jam);
        $diff_jam = number_format($start_jam->diffInMinutes($end_jam) / 60, 1);

        // check if jenis hari is weekday
        if ($spl->id_jenis_hari == 1) {
            // get poin kerja
            for ($i = 0; $i < $poin_kerja->count(); $i++) {
                // check if diff hours is between poin kerja
                if ($diff_jam == $poin_kerja[$i]->jam_lembur) {
                    $point = $poin_kerja[$i]->point;
                }
            }
        } else {
            // get poin libur
            for ($i = 0; $i < $poin_libur->count(); $i++) {
                // check if diff hours is between poin libur
                if ($diff_jam == $poin_libur[$i]->jam_lembur) {
                    $point = $poin_libur[$i]->point;
                }
            }
        }

        $istirahat = $spl->istirahat;
        $total_waktu = $diff_jam - $istirahat;
        // get tarif lembur
        $tarif_total_lembur = $point * $karyawan->tarif_lembur + $request->uang_makan;

        try {
            $detail_spl = DetailSpl::find($request->id_detail);
            $detail_spl->spl_id = $request->id;
            $detail_spl->karyawan_id = $request->karyawan_id;
            $detail_spl->lama_lembur = $total_waktu;
            $detail_spl->uang_makan = $request->uang_makan;
            $detail_spl->poin_lembur = $point;
            $detail_spl->tarif_total_lembur = $tarif_total_lembur;
            $detail_spl->updated_by = auth()->user()->karyawan->nama_karyawan;
            $detail_spl->save();
            return redirect('/koordinator/data-pengajuan/detail-pengajuan/' . $spl->id)->with('toast_success', 'Data berhasil diubah');
        } catch (\Throwable $th) {
            return redirect('/koordinator/data-pengajuan/detail-pengajuan/' . $spl->id)->with('toast_error', $th->getMessage());
        }
    }

    // function for delete list employee
    public function deleteListEmployee(Request $request)
    {
        $detail_spl = DetailSpl::find($request->id_delete);
        $spl = Spl::where('id', '=', $detail_spl->spl_id)->first();

        try {
            $detail_spl->delete();
            $http = Http::delete('http://192.168.1.99:8080/simetri-api-local/api/local/spl/' . $spl->id_spl . '/' . $detail_spl->karyawan->nik_karyawan);
            return redirect('/koordinator/data-pengajuan/detail-pengajuan/' . $request->id_spl)->with('toast_success', 'Data berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->route('koordinator.buat-pengajuan-lembur')->with('toast_error', $th->getMessage());
        }
    }

    // function for find employee by spl id
    public function findEmployee()
    {
        $employee = Karyawan::with('bagian')
            ->where('nama_karyawan', request('nama_karyawan'))
            ->where('nik_karyawan', request('nik_karyawan'))
            ->first();
        $uang_makan = UangMakan::all();

        $spl = Spl::where('id', '=', request('id_spl'))->first();

        $uang_tetap = $uang_makan[0]->uang_makan;
        $uang_kontrak = $uang_makan[1]->uang_makan;
        $uang_harian = $uang_makan[2]->uang_makan;

        $diff_jam = Carbon::parse($spl->start_jam)->diffInMinutes(Carbon::parse($spl->end_jam)) / 60;
        $diff_jam = number_format($diff_jam, 1);
        $lama_lembur = $diff_jam - $spl->istirahat;

        // check if lama lembur more than 4 hours
        if ($lama_lembur >= 4) {
            // check if employee is tetap
            if ($employee->status_kontrak == 'tetap') {
                $status = 'tetap';
                $uang_makan = $uang_tetap;
            }
            // check if employee is kontrak
            else if ($employee->status_kontrak == 'kontrak') {
                $status = 'kontrak';
                $uang_makan = $uang_kontrak;
            }
            // check if employee is harian
            else {
                $status = 'harian';
                $uang_makan = $uang_harian;
            }
        }
        // check if lama lembur less than 4 hours
        else {
            // check if employee is tetap
            if ($employee->status_kontrak == 'tetap') {
                $status = 'tetap';
                $uang_makan = '0';
            }
            // check if employee is kontrak
            else if ($employee->status_kontrak == 'kontrak') {
                $status = 'kontrak';
                $uang_makan = '0';
            }
            // check if employee is harian
            else {
                $status = 'harian';
                $uang_makan = '0';
            }
        }

        return response()->json([
            'employee' => [
                'nik_karyawan' => $employee->nik_karyawan,
                'nama_karyawan' => $employee->nama_karyawan,
                'id' => $employee->id,
                'uang_makan' => $uang_makan,
            ],
        ]);
    }

    public function findProject($code)
    {
        $project = Http::get('http://192.168.1.99:8080/simetri-api-local/api/local/project/' . $code)['data']; // get project by code
        // $project = Http::get('http://system.sinarmetrindo.co.i   d:18881/simetri-api-local/api/local/project/' . $code)['data']; // maintenance if not connet to local
        // $project = Http::get('http://127.0.0.1:8000/api/local/project/' . $code)['data']; // maintenance if not connet to local
        return response()->json($project);
    }
}
