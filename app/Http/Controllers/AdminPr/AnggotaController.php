<?php

namespace App\Http\Controllers\AdminPr;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Jabatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggotas = Anggota::where('organisasi_unit_id', Auth::user()->organisasi_unit_id)
                    ->latest()->paginate(10);
        return view('admin_pr.anggota.index', compact('anggotas'));
    }

    public function create()
    {
        $jabatans = Jabatan::whereIn('level_akses', ['pr', 'all'])->get();
        return view('admin_pr.anggota.create', compact('jabatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nik' => 'required|digits:16|unique:anggotas',
            'email' => 'required|email|unique:users',
            'jabatan_id' => 'required'
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make('ansor123'),
            'role' => 'anggota',
            'organisasi_unit_id' => Auth::user()->organisasi_unit_id,
        ]);

        Anggota::create($request->all() + [
            'user_id' => $user->id,
            'organisasi_unit_id' => Auth::user()->organisasi_unit_id
        ]);

        return redirect()->route('admin_pr.anggota.index')->with('success', 'Anggota Ranting berhasil ditambahkan.');
    }

    public function edit($id)
    {
        // 1. Cari data berdasarkan ID secara manual
        $anggota = Anggota::find($id);

        // 2. Jika data tidak ditemukan di database
        if (!$anggota) {
            return redirect()->route('admin_pr.anggota.index')
                             ->with('error', 'Kader dengan ID ' . $id . ' tidak ditemukan di database.');
        }

        $adminUnitId = Auth::user()->organisasi_unit_id;

        // 3. Cek apakah ID Unit Anggota sama dengan ID Unit Admin
        // Kita gunakan (int) untuk memastikan perbandingan angka benar
        if ((int)$anggota->organisasi_unit_id !== (int)$adminUnitId) {
            abort(403, 'Akses Ditolak. Unit Anda: ' . $adminUnitId . ', Unit Anggota: ' . ($anggota->organisasi_unit_id ?? 'KOSONG'));
        }

        $jabatans = Jabatan::whereIn('level_akses', ['pr', 'all'])->get();
        return view('admin_pr.anggota.edit', compact('anggota', 'jabatans'));
    }

    /**
     * Update Data dengan Pencarian Manual
     */
    public function update(Request $request, $id)
    {
        $anggota = Anggota::findOrFail($id);
        $unitId = Auth::user()->organisasi_unit_id;

        if ((int)$anggota->organisasi_unit_id !== (int)$unitId) {
            abort(403);
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|numeric|digits:16|unique:anggotas,nik,' . $id,
            'jabatan_id' => 'required|exists:jabatans,id',
        ]);

        $anggota->update($request->all());
        
        if ($anggota->user) {
            $anggota->user->update(['nama' => $request->nama]);
        }

        return redirect()->route('admin_pr.anggota.index')
                         ->with('success', 'Data kader berhasil diperbarui.');
    }
}