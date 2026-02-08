<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\RiwayatPengkaderan;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengkaderanController extends Controller
{
    public function index()
    {
        $anggota = Anggota::where('user_id', Auth::id())->firstOrFail();
        $pengkaderans = RiwayatPengkaderan::where('anggota_id', $anggota->id)
            ->latest('tanggal_pelaksanaan')
            ->paginate(10);

        return view('anggota.pengkaderan.index', compact('pengkaderans', 'anggota'));
    }

    public function create()
    {
        return view('anggota.pengkaderan.create');
    }

    public function store(Request $request)
    {
        $anggota = Anggota::where('user_id', Auth::id())->firstOrFail();

        $validated = $request->validate([
            'jenis_pengkaderan' => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|date',
            'pelaksana' => 'required|string|max:255',
            'nomor_sertifikat' => 'nullable|string|max:100',
            'url_dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'jenis_pengkaderan.required' => 'Jenis pengkaderan wajib diisi',
            'tanggal_pelaksanaan.required' => 'Tanggal pelaksanaan wajib diisi',
            'pelaksana.required' => 'Pelaksana wajib diisi',
            'url_dokumen.mimes' => 'Dokumen harus berformat PDF, JPG, JPEG, atau PNG',
            'url_dokumen.max' => 'Ukuran dokumen maksimal 2MB',
        ]);

        // Handle file upload
        if ($request->hasFile('url_dokumen')) {
            $file = $request->file('url_dokumen');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('pengkaderan', $filename, 'public');
            $validated['url_dokumen'] = $path;
        }

        $validated['anggota_id'] = $anggota->id;

        RiwayatPengkaderan::create($validated);

        return redirect()->route('anggota.pengkaderan.index')
            ->with('success', 'Data pengkaderan berhasil ditambahkan!');
    }

    public function show(RiwayatPengkaderan $pengkaderan)
    {
        $anggota = Anggota::where('user_id', Auth::id())->firstOrFail();

        // Pastikan pengkaderan milik anggota yang login
        if ($pengkaderan->anggota_id !== $anggota->id) {
            abort(403);
        }

        return view('anggota.pengkaderan.show', compact('pengkaderan'));
    }

    public function edit(RiwayatPengkaderan $pengkaderan)
    {
        $anggota = Anggota::where('user_id', Auth::id())->firstOrFail();

        // Pastikan pengkaderan milik anggota yang login
        if ($pengkaderan->anggota_id !== $anggota->id) {
            abort(403);
        }

        return view('anggota.pengkaderan.edit', compact('pengkaderan'));
    }

    public function update(Request $request, RiwayatPengkaderan $pengkaderan)
    {
        $anggota = Anggota::where('user_id', Auth::id())->firstOrFail();

        // Pastikan pengkaderan milik anggota yang login
        if ($pengkaderan->anggota_id !== $anggota->id) {
            abort(403);
        }

        $validated = $request->validate([
            'jenis_pengkaderan' => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|date',
            'pelaksana' => 'required|string|max:255',
            'nomor_sertifikat' => 'nullable|string|max:100',
            'url_dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('url_dokumen')) {
            // Delete old file if exists
            if ($pengkaderan->url_dokumen && Storage::disk('public')->exists($pengkaderan->url_dokumen)) {
                Storage::disk('public')->delete($pengkaderan->url_dokumen);
            }

            $file = $request->file('url_dokumen');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('pengkaderan', $filename, 'public');
            $validated['url_dokumen'] = $path;
        }

        $pengkaderan->update($validated);

        return redirect()->route('anggota.pengkaderan.index')
            ->with('success', 'Data pengkaderan berhasil diperbarui!');
    }

    public function destroy(RiwayatPengkaderan $pengkaderan)
    {
        $anggota = Anggota::where('user_id', Auth::id())->firstOrFail();

        // Pastikan pengkaderan milik anggota yang login
        if ($pengkaderan->anggota_id !== $anggota->id) {
            abort(403);
        }

        // Delete file if exists
        if ($pengkaderan->url_dokumen && Storage::disk('public')->exists($pengkaderan->url_dokumen)) {
            Storage::disk('public')->delete($pengkaderan->url_dokumen);
        }

        $pengkaderan->delete();

        return redirect()->route('anggota.pengkaderan.index')
            ->with('success', 'Data pengkaderan berhasil dihapus!');
    }
}
