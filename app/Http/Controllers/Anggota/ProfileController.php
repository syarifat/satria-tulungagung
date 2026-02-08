<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\OrganisasiUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Tampilkan form edit profil anggota
     */
    public function edit()
    {
        $user = Auth::user();
        $anggota = Anggota::where('user_id', $user->id)->firstOrFail();
        $kecamatans = Kecamatan::orderBy('nama')->get();

        // Load desa untuk domisili dan unit organisasi
        $desasDomisili = Desa::where('kecamatan_id', $anggota->kecamatan_id)->get();

        // Ambil data organisasi unit
        $organisasiUnit = OrganisasiUnit::find($anggota->organisasi_unit_id);
        $tingkatan = $organisasiUnit ? $organisasiUnit->level : null;

        // Untuk PR, ambil desa dari unit
        $desasUnit = [];
        if ($organisasiUnit && $organisasiUnit->kecamatan_id) {
            $desasUnit = Desa::where('kecamatan_id', $organisasiUnit->kecamatan_id)->get();
        }

        return view('anggota.profile.edit', compact(
            'user',
            'anggota',
            'kecamatans',
            'desasDomisili',
            'organisasiUnit',
            'tingkatan',
            'desasUnit'
        ));
    }

    /**
     * Update profil anggota
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $anggota = Anggota::where('user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'nik' => 'required|string|size:16|unique:anggotas,nik,' . $anggota->id,
            'nia_ansor' => 'nullable|string|max:50',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date|before:today',
            'kelamin' => 'required|in:L,P',
            'status_kawin' => 'required|in:belum_kawin,kawin,cerai_hidup,cerai_mati',
            'notelp' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
            'kecamatan_id' => 'required|exists:kecamatans,id',
            'desa_id' => 'required|exists:desas,id',
            'tingkatan_organisasi' => 'required|in:pac,pr',
            'unit_kecamatan_id' => 'required|exists:kecamatans,id',
            'unit_desa_id' => 'nullable|exists:desas,id|required_if:tingkatan_organisasi,pr',
            'last_education' => 'nullable|string|max:50',
            'job_title' => 'nullable|string|max:100',
            'job_address' => 'nullable|string|max:255',
        ], [
            'nik.required' => 'NIK wajib diisi',
            'nik.size' => 'NIK harus 16 digit',
            'nik.unique' => 'NIK sudah terdaftar',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi',
            'tanggal_lahir.before' => 'Tanggal lahir tidak valid',
            'notelp.required' => 'Nomor telepon wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'kecamatan_id.required' => 'Kecamatan domisili wajib dipilih',
            'desa_id.required' => 'Desa domisili wajib dipilih',
            'tingkatan_organisasi.required' => 'Tingkatan organisasi wajib dipilih',
            'unit_kecamatan_id.required' => 'PAC (Kecamatan) wajib dipilih',
            'unit_desa_id.required_if' => 'PR (Desa) wajib dipilih untuk tingkat Ranting',
        ]);

        // Cari organisasi unit berdasarkan pilihan
        if ($validated['tingkatan_organisasi'] === 'pac') {
            $organisasiUnit = OrganisasiUnit::where('level', 'pac')
                ->where('kecamatan_id', $validated['unit_kecamatan_id'])
                ->first();
        } else {
            $organisasiUnit = OrganisasiUnit::where('level', 'pr')
                ->where('desa_id', $validated['unit_desa_id'])
                ->first();
        }

        if (!$organisasiUnit) {
            return back()->withErrors(['tingkatan_organisasi' => 'Unit organisasi tidak ditemukan.'])
                ->withInput();
        }

        // Update data anggota
        $anggota->update([
            'organisasi_unit_id' => $organisasiUnit->id,
            'nik' => $validated['nik'],
            'nia_ansor' => $validated['nia_ansor'],
            'tempat_lahir' => $validated['tempat_lahir'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'kelamin' => $validated['kelamin'],
            'status_kawin' => $validated['status_kawin'],
            'notelp' => $validated['notelp'],
            'alamat' => $validated['alamat'],
            'kecamatan_id' => $validated['kecamatan_id'],
            'desa_id' => $validated['desa_id'],
            'last_education' => $validated['last_education'],
            'job_title' => $validated['job_title'],
            'job_address' => $validated['job_address'],
        ]);

        // Update juga organisasi unit di user
        $user->update([
            'organisasi_unit_id' => $organisasiUnit->id,
        ]);

        return redirect()->route('anggota.dashboard')
            ->with('success', 'Profil berhasil diperbarui!');
    }
}
