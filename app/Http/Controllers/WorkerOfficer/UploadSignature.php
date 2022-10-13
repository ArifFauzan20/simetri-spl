<?php

namespace App\Http\Controllers\WorkerOfficer;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Upload;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UploadSignature extends Controller
{
    public function index()
    {
        $employes = Karyawan::all();
        $uploads = Upload::with('karyawan')->latest()->get();

        return view('page.worker-officer.upload.index', [
            'title' => 'Upload Signature',
        ], compact('employes', 'uploads'));
    }

    public function uploadSignature(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'nama_karyawan' => 'required',
            'nama_karyawan_create' => 'required',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:1024',
        ], [
            'nama_karyawan.required' => 'NIK karyawan tidak boleh kosong',
            'nama_karyawan_create.required' => 'Nama karyawan yang mengupload tidak boleh kosong',
            'image.required' => 'Foto signature tidak boleh kosong',
            'image.image' => 'Foto signature harus berupa gambar',
            'image.mimes' => 'Foto signature harus berupa gambar dengan format jpg, jpeg, png',
            'image.max' => 'File tanda tangan tidak boleh lebih dari 1MB',
        ]);

        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated)->withInput();
        }

        $name = $request->nama_karyawan . '.' . $request->file('image')->getClientOriginalExtension();
        $path = $request->image->move(public_path('signatures'), $name);
        try {
            $upload = new Upload();
            $upload->karyawan_id = $request->karyawan_id;
            $upload->file_name = $name;
            $upload->path = $path;
            $upload->uploaded_by = auth()->user()->karyawan->nama_karyawan;
            $upload->save();
            return redirect()->back()->with('toast_success', 'File tanda tangan berhasil diupload');
        } catch (\Throwable $th) {
            return redirect()->back()->with('toast_error', 'File tanda tangan gagal diupload');
        }
    }

    public function deleteSignature($id)
    {
        $upload = Upload::find($id);
        if (file_exists(public_path('signatures/' . $upload->file_name))) {
            unlink(public_path('signatures/' . $upload->file_name));
            $upload->delete();
            return redirect()->back()->with('toast_success', 'File tanda tangan berhasil dihapus');
        } else {
            return redirect()->back()->with('toast_error', 'File tanda tangan tidak ditemukan');
        }
    }
}
