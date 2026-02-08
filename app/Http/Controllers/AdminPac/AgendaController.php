<?php

namespace App\Http\Controllers\AdminPac;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\OrganisasiUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgendaController extends Controller
{
    public function index()
    {
        $unitId = Auth::user()->organisasi_unit_id;
        $unitIds = OrganisasiUnit::where('parent_id', $unitId)->pluck('id')->push($unitId);

        // Ambil agenda milik PAC ini dan Ranting di bawahnya
        $agendas = Agenda::with('organisasiUnit')
                    ->whereIn('organisasi_unit_id', $unitIds)
                    ->latest()
                    ->paginate(9);

        return view('admin_pac.agenda.index', compact('agendas'));
    }

    public function create()
    {
        $unitId = Auth::user()->organisasi_unit_id;
        // Pilihan unit: PAC itu sendiri atau Ranting di bawahnya
        $units = OrganisasiUnit::where('parent_id', $unitId)->get();
        
        return view('admin_pac.agenda.create', compact('units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'deskripsi' => 'required|string',
            'organisasi_unit_id' => 'required|exists:organisasi_units,id',
        ]);

        Agenda::create($request->all() + [
            'status' => 'pending' // Otomatis pending untuk monitoring PC
        ]);

        return redirect()->route('admin_pac.agenda.index')
                         ->with('success', 'Agenda kegiatan berhasil diajukan.');
    }

    public function show(Agenda $agenda)
    {
        // Proteksi akses wilayah
        $unitId = Auth::user()->organisasi_unit_id;
        if ($agenda->organisasi_unit_id !== $unitId && $agenda->organisasiUnit->parent_id !== $unitId) {
            abort(403);
        }

        return view('admin_pac.agenda.show', compact('agenda'));
    }
}