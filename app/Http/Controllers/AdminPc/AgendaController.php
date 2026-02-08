<?php

namespace App\Http\Controllers\AdminPc;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index(Request $request)
    {
        $agendas = Agenda::with('organisasiUnit')
                    ->latest()
                    ->paginate(10);
        return view('admin_pc.agenda.index', compact('agendas'));
    }

    public function updateStatus(Request $request, Agenda $agenda)
    {
        $request->validate(['status' => 'required|in:diterima,ditolak']);
        $agenda->update(['status' => $request->status]);
        return back()->with('success', 'Status agenda berhasil diperbarui.');
    }

    public function show(Agenda $agenda)
    {
        // Mengambil data agenda beserta nama unit organisasinya
        $agenda->load('organisasiUnit');
        
        return view('admin_pc.agenda.show', compact('agenda'));
    }
}