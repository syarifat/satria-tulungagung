<?php

namespace App\Http\Controllers\AdminPac;

use App\Http\Controllers\Controller;
use App\Models\OrganisasiUnit;
use App\Models\Desa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RantingController extends Controller
{
    public function index()
    {
        $unitId = Auth::user()->organisasi_unit_id;

        // Ambil Ranting yang parent-nya adalah PAC ini
        $rantings = OrganisasiUnit::with(['desa', 'anggotas'])
                    ->where('parent_id', $unitId)
                    ->where('level', 'pr')
                    ->orderBy('nama', 'asc')
                    ->get();

        return view('admin_pac.ranting.index', compact('rantings'));
    }

    public function show(OrganisasiUnit $ranting)
    {
        // Proteksi: Pastikan ranting yang diakses milik PAC ini
        if ($ranting->parent_id !== Auth::user()->organisasi_unit_id) {
            abort(403, 'Unit ini berada di luar wilayah koordinasi Anda.');
        }

        $ranting->load(['desa', 'anggotas.jabatan']);
        return view('admin_pac.ranting.show', compact('ranting'));
    }

    public function edit(OrganisasiUnit $ranting)
    {
        if ($ranting->parent_id !== Auth::user()->organisasi_unit_id) {
            abort(403);
        }

        // Ambil data desa untuk pilihan (jika ingin mengubah desa cakupan)
        $desas = Desa::orderBy('nama', 'asc')->get();
        return view('admin_pac.ranting.edit', compact('ranting', 'desas'));
    }

    public function update(Request $request, OrganisasiUnit $ranting)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'desa_id' => 'required|exists:desas,id',
        ]);

        $ranting->update($request->all());

        return redirect()->route('admin_pac.ranting.index')
                         ->with('success', 'Data Ranting berhasil diperbarui.');
    }
}