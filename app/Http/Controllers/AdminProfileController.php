<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\OrganisasiUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminProfileController extends Controller
{
    /**
     * Tampilkan form edit profil admin (PC, PAC, PR)
     */
    public function edit()
    {
        $user = Auth::user();
        $anggota = Anggota::where('user_id', $user->id)->firstOrFail();
        $kecamatans = Kecamatan::orderBy('nama')->get();

        // Load desa untuk domisili
        $desasDomisili = Desa::where('kecamatan_id', $anggota->kecamatan_id)->get();

        // Ambil data organisasi unit yang di-manage admin ini
        $organisasiUnit = OrganisasiUnit::find($user->organisasi_unit_id);

        // Ambil semua jabatan
        $jabatans = \App\Models\Jabatan::orderBy('nama')->get();

        return view('admin.profile.edit', compact(
            'user',
            'anggota',
            'kecamatans',
            'desasDomisili',
            'organisasiUnit',
            'jabatans'
        ));
    }

    /**
     * Update profil admin + data organisasi unit
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $anggota = Anggota::where('user_id', $user->id)->firstOrFail();
        $organisasiUnit = OrganisasiUnit::find($user->organisasi_unit_id);

        $validated = $request->validate([
            // Data Pribadi
            'nama' => 'required|string|max:100',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'jabatan_id' => 'required|exists:jabatans,id',
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
            'last_education' => 'nullable|string|max:50',
            'job_title' => 'nullable|string|max:100',
            'job_address' => 'nullable|string|max:255',

            // Data Organisasi Unit
            'unit_alamat_sekretariat' => 'nullable|string|max:500',
            'unit_email' => 'nullable|email|max:100',
            'unit_notelp' => 'nullable|string|max:20',
        ], [
            'nama.required' => 'Nama lengkap wajib diisi',
            'foto_profil.image' => 'File harus berupa gambar',
            'foto_profil.max' => 'Ukuran foto maksimal 2MB',
            'jabatan_id.required' => 'Jabatan wajib dipilih',
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
        ]);

        // Handle file upload
        $avatarPath = $anggota->url_foto; // Keep existing
        if ($request->hasFile('foto_profil')) {
            $path = $request->file('foto_profil')->store('avatars', 'public');
            $avatarPath = asset('storage/' . $path);
        }

        DB::transaction(function () use ($anggota, $organisasiUnit, $validated, $avatarPath) {
            // Update data anggota
            $anggota->update([
                'nama' => $validated['nama'],
                'url_foto' => $avatarPath,
                'jabatan_id' => $validated['jabatan_id'],
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

            // Update user (nama & avatar)
            $anggota->user->update([
                'nama' => $validated['nama'],
                'avatar' => $avatarPath,
            ]);

            // Update data organisasi unit
            if ($organisasiUnit) {
                $organisasiUnit->update([
                    'alamat_sekretariat' => $validated['unit_alamat_sekretariat'],
                    'email' => $validated['unit_email'],
                    'notelp' => $validated['unit_notelp'],
                ]);
            }
        });

        return redirect()->route('admin.profile.edit')
            ->with('success', 'Profil dan data organisasi berhasil diperbarui!');
    }
}
