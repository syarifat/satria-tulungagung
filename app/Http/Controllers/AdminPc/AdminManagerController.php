<?php

namespace App\Http\Controllers\AdminPc;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Anggota;
use App\Models\OrganisasiUnit;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminManagerController extends Controller
{
    /**
     * Display a listing of the admins.
     */
    public function index(Request $request)
    {
        // Get users who are admins (admin_pac or admin_pr)
        $query = User::with(['anggota', 'organisasiUnit'])
            ->whereIn('role', ['admin_pac', 'admin_pr']);

        // Filter by PAC/PR if needed
        if ($request->search) {
            $query->where('nama', 'like', "%{$request->search}%");
        }

        if ($request->pac_id) {
            // If filtering by PAC, show PAC admin AND PR admins under it
            $unitIds = OrganisasiUnit::where('id', $request->pac_id)
                ->orWhere('parent_id', $request->pac_id)
                ->pluck('id');
            $query->whereIn('organisasi_unit_id', $unitIds);
        }

        if ($request->pr_id) {
            $query->where('organisasi_unit_id', $request->pr_id);
        }

        $admins = $query->latest()->paginate(10)->withQueryString();

        // Data for filters
        $allPacs = OrganisasiUnit::where('level', 'pac')->orderBy('nama', 'asc')->get();
        $prs = [];
        if ($request->pac_id) {
            $prs = OrganisasiUnit::where('parent_id', $request->pac_id)
                ->where('level', 'pr')
                ->orderBy('nama', 'asc')
                ->get();
        }

        return view('admin_pc.admin_manager.index', compact('admins', 'allPacs', 'prs'));
    }

    /**
     * Show the form for creating a new admin (promoting member).
     */
    public function create(Request $request)
    {
        // Search for members to promote
        $query = Anggota::with(['user', 'organisasiUnit'])
            ->whereHas('user', function ($q) {
                $q->where('role', 'anggota'); // Only regular members
            });

        if ($request->search) {
            $query->where('nama', 'like', "%{$request->search}%")
                ->orWhere('nik', 'like', "%{$request->search}%");
        } else {
            // Don't show all if no search, maybe empty or latest 10
            // But for usability, maybe show latest 10
        }

        $candidates = $query->latest()->paginate(10);

        return view('admin_pc.admin_manager.create', compact('candidates'));
    }

    /**
     * Promote a member to admin.
     */
    public function store(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggotas,id',
        ]);

        $anggota = Anggota::findOrFail($request->anggota_id);
        $organisasiUnit = $anggota->organisasiUnit;

        // Determine New Role
        if ($organisasiUnit->level === 'pac') {
            $newRole = 'admin_pac';
            // Assuming ID 2 is Ketua PAC as per previous controller
            $jabatanId = 2;
        } elseif ($organisasiUnit->level === 'pr') {
            $newRole = 'admin_pr';
            // Assuming ID 3 is Ketua Ranting
            $jabatanId = 3;
        } else {
            return back()->with('error', 'Anggota PC tidak bisa dijadikan admin unit via menu ini.');
        }

        // Check if unit already has admin
        $existingAdmin = User::where('organisasi_unit_id', $organisasiUnit->id)
            ->where('role', $newRole)
            ->where('id', '!=', $anggota->user_id)
            ->first();

        if ($existingAdmin) {
            return back()->with('error', "Gagal! Unit {$organisasiUnit->nama} sudah memiliki admin: {$existingAdmin->nama}. Harap copot admin lama terlebih dahulu.");
        }

        DB::transaction(function () use ($anggota, $newRole, $jabatanId) {
            // Update User Role
            $anggota->user->update(['role' => $newRole]);

            // Update Jabatan (Optional, but good for consistency)
            $anggota->update(['jabatan_id' => $jabatanId]);
        });

        return redirect()->route('admin_pc.admin-manager.index')
            ->with('success', "Berhasil menjadikan {$anggota->nama} sebagai admin {$organisasiUnit->nama}.");
    }

    /**
     * Demote an admin back to member.
     */
    public function destroy($userId)
    {
        $user = User::findOrFail($userId);

        if (!in_array($user->role, ['admin_pac', 'admin_pr'])) {
            return back()->with('error', 'User ini bukan admin unit.');
        }

        DB::transaction(function () use ($user) {
            $user->update(['role' => 'anggota']);
            // Optionally reset jabatan to default 'Anggota' (id 1 usually) or keep as is?
            // Safer to just change role. Jabatan might still be 'Ketua' but without system admin access?
            // Let's reset jabatan to 'Anggota' (ID 1 as per assumption if exists, or just leave it)
            // Ideally we check if Jabatan 1 exists.
            $anggota = $user->anggota;
            if ($anggota) {
                // Assuming ID 10 is 'Anggota' based on AnggotaController logic
                $anggota->update(['jabatan_id' => 10]);
            }
        });

        return redirect()->route('admin_pc.admin-manager.index')
            ->with('success', "Akses admin untuk {$user->nama} telah dicabut.");
    }
}
