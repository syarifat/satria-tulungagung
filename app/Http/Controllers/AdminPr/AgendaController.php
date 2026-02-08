<?php

namespace App\Http\Controllers\AdminPr;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgendaController extends Controller
{
    public function index()
    {
        // Hanya ambil agenda milik unit Ranting ini
        $agendas = Agenda::where('organisasi_unit_id', Auth::user()->organisasi_unit_id)
                    ->latest()
                    ->paginate(9);

        return view('admin_pr.agenda.index', compact('agendas'));
    }

    public function create()
    {
        return view('admin_pr.agenda.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'deskripsi' => 'required|string',
        ]);

        Agenda::create($request->all() + [
            'organisasi_unit_id' => Auth::user()->organisasi_unit_id,
            'status' => 'pending' 
        ]);

        return redirect()->route('admin_pr.agenda.index')
                         ->with('success', 'Agenda kegiatan desa berhasil dilaporkan.');
    }

    public function show($id)
    {
        $agenda = Agenda::findOrFail($id);

        // Proteksi akses: pastikan admin hanya melihat agenda unitnya sendiri
        if ($agenda->organisasi_unit_id != Auth::user()->organisasi_unit_id) {
            abort(403, 'Anda tidak memiliki akses ke agenda wilayah lain.');
        }

        return view('admin_pr.agenda.show', compact('agenda'));
    }
}