<?php

namespace App\Http\Controllers\WorkerOfficer;

use App\Http\Controllers\Controller;
use App\Models\UangMakan;
use Illuminate\Http\Request;

class UangMakanController extends Controller
{
    public function index()
    {
        $uang_makan = UangMakan::all();
        return view('page.worker-officer.uang-makan.index', [
            'title' => 'Uang Makan',
        ], compact('uang_makan'));
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'status_kontrak' => 'required',
            'uang_makan' => 'required',
        ]);

        $validated['updated_by'] = auth()->user()->role->role_user;

        $uangmakan = new UangMakan;
        $uangmakan->status = $validated['status_kontrak'];
        $uangmakan->uang_makan = $validated['uang_makan'];
        $uangmakan->updated_by = $validated['updated_by'];
        $uangmakan->save();

        return redirect()->route('adminwo.uang-makan')->with('toast_success', 'Data berhasil ditambahkan');
    }

    public function edit(Request $request)
    {
        $validated = $request->validate([
            'status_kontrak' => 'required',
            'uang_makan' => 'required',
        ]);

        $validated['updated_by'] = auth()->user()->role->role_user;

        $uangmakan = UangMakan::find($request->id);
        $uangmakan->status = $validated['status_kontrak'];
        $uangmakan->uang_makan = $validated['uang_makan'];
        $uangmakan->updated_by = $validated['updated_by'];
        $uangmakan->save();

        return redirect()->route('adminwo.uang-makan')->with('toast_success', 'Data berhasil diubah');
    }

    public function delete(Request $request)
    {
        $uangmakan = UangMakan::find($request->id);
        $uangmakan->delete();

        return redirect()->route('adminwo.uang-makan')->with('toast_success', 'Data berhasil dihapus');
    }
}
