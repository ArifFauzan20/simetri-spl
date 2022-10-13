<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bagian;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;

class DivisionsController extends Controller
{
    public function index()
    {
        $divisions = Bagian::all();
        return view('page.admin.divisions.index', [
            'title' => 'Divisions',
            'header' => 'Divisions',
        ], compact('divisions'));
    }

    public function createDivision(Request $request)
    {
        $validated = $request->validate([
            'nama_bagian' => 'required|string|max:255',
        ]);

        if (auth()->user()->role_id == 1) {
            $update_by = 'Super Admin';
        }

        $validated['update_by'] = $update_by;

        Bagian::create($validated);
        // dd($request->all());
        Alert::toast('Data divisi berhasil ditambah', 'success');
        return redirect()->route('superadmin.divisions');
    }

    public function updateDivision(Request $request)
    {
        $validated = $request->validate([
            'nama_bagian' => 'required|string|max:255',
        ]);

        Bagian::where('id', $request->id)->update([
            'nama_bagian' => $request->nama_bagian,
            'update_by' => auth()->user()->role_id == 1 ? 'Super Admin' : auth()->user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        Alert::toast('Data divisi berhasil diubah', 'success');
        return redirect()->route('superadmin.divisions');
    }

    public function deleteDivision(Request $request)
    {
        Bagian::where('id', $request->id)->delete();
        Alert::toast('Data divisi berhasil dihapus', 'success');
        return redirect()->route('superadmin.divisions');
    }
}
