<?php

namespace App\Http\Controllers\AdminPc;

use App\Http\Controllers\Controller;
use App\Models\Surat;
use Illuminate\Http\Request;

class SuratController extends Controller
{
    public function index(Request $request)
    {
        $query = Surat::with(['organisasiUnit', 'indexSurat']);

        // Filter status (Pending, Diterima, Ditolak)
        if ($request->status) {
            $query->where('status', $request->status);
        } else {
            $query->orderByRaw("FIELD(status, 'pending', 'diterima', 'ditolak')");
        }

        $surats = $query->latest()->paginate(10)->withQueryString();
        return view('admin_pc.surat.index', compact('surats'));
    }

    public function show(Surat $surat)
    {
        // Load relasi agar data organisasi dan index surat muncul di detail
        $surat->load(['organisasiUnit', 'indexSurat']);
        return view('admin_pc.surat.show', compact('surat'));
    }

    public function updateStatus(Request $request, Surat $surat)
    {
        $request->validate(['status' => 'required|in:diterima,ditolak']);
        
        $surat->update([
            'status' => $request->status,
            'diterima_oleh' => auth()->id(),
        ]);

        return back()->with('success', 'Status surat berhasil diperbarui.');
    }
}