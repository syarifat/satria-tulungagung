<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminPc\UnitOrganisasiController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\AdminPc\JabatanController;
use App\Http\Controllers\AdminPc\IndexSuratController;
use App\Http\Controllers\AdminPc\AnggotaController;
use App\Http\Controllers\AdminPc\SuratController;
use App\Http\Controllers\AdminPc\AgendaController;
use App\Http\Controllers\AdminPc\DashboardController;
use App\Http\Controllers\AdminPc\PekerjaanController;
use App\Http\Controllers\AdminPc\AdminManagerController;

use App\Http\Controllers\AdminPac\DashboardController as PacDashboard;
use App\Http\Controllers\AdminPac\RantingController;
use App\Http\Controllers\AdminPac\AnggotaController as PacAnggota;
use App\Http\Controllers\AdminPac\SuratController as PacSurat;
use App\Http\Controllers\AdminPac\AgendaController as PacAgenda;

use App\Http\Controllers\AdminPr\DashboardController as PrDashboard;
use App\Http\Controllers\AdminPr\AnggotaController as PrAnggota;
use App\Http\Controllers\AdminPr\SuratController as PrSurat;
use App\Http\Controllers\AdminPr\AgendaController as PrAgenda;

use App\Http\Controllers\Anggota\DashboardController as AnggotaDashboard;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = \Illuminate\Support\Facades\Auth::user();

    return match ($user->role) {
        'admin_pc' => redirect()->route('admin_pc.dashboard'),
        'admin_pac' => redirect()->route('admin_pac.dashboard'),
        'admin_pr' => redirect()->route('admin_pr.dashboard'),
        default => redirect()->route('anggota.dashboard'),
    };
})->middleware(['auth', 'verified', 'profile.complete'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile routes untuk Admin (PC, PAC, PR)
    Route::middleware(['role:admin_pc,admin_pac,admin_pr'])->group(function () {
        Route::get('/admin/profile', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');
        Route::put('/admin/profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');
    });

    // Profile routes untuk Anggota biasa (menggunakan ProfileController lama)
    Route::middleware(['role:anggota'])->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // API untuk mendapatkan daftar desa berdasarkan kecamatan (untuk dropdown dinamis)
    Route::get('/api/wilayah/desa/{kecamatan_id}', [WilayahController::class, 'getDesaByKecamatan'])
        ->name('api.wilayah.desa');
});

// Hanya Admin PC yang bisa akses
Route::middleware(['auth', 'profile.complete', 'role:admin_pc'])->prefix('admin-pc')->name('admin_pc.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin_pc.dashboard');
    })->name('dashboard');
    // Route::resource('anggota', AnggotaController::class);
    Route::resource('anggota', AnggotaController::class)->parameters(['anggota' => 'anggota']);
    Route::resource('unit-organisasi', UnitOrganisasiController::class);
    Route::resource('jabatan', JabatanController::class);
    Route::resource('index-surat', IndexSuratController::class);
    Route::resource('surat', SuratController::class);
    Route::patch('surat/{surat}/status', [SuratController::class, 'updateStatus'])->name('surat.status');
    Route::resource('agenda', AgendaController::class);
    Route::patch('agenda/{agenda}/status', [AgendaController::class, 'updateStatus'])->name('agenda.status');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/data-pekerjaan', [PekerjaanController::class, 'index'])->name('pekerjaan.index');

    // Pengkaderan
    Route::resource('pengkaderan', \App\Http\Controllers\AdminPc\PengkaderanController::class)->only(['index', 'show']);

    // Manajemen Admin Unit
    Route::resource('admin-manager', AdminManagerController::class)->except(['show', 'edit', 'update']);
});

// Admin PAC & PC bisa akses (PR dilarang)
Route::middleware(['auth', 'profile.complete', 'role:admin_pac'])->prefix('admin-pac')->name('admin_pac.')->group(function () {
    Route::get('/dashboard', [PacDashboard::class, 'index'])->name('dashboard');
    Route::resource('ranting', RantingController::class);
    Route::resource('anggota', PacAnggota::class);
    Route::get('/anggota-export-pdf', [PacAnggota::class, 'exportPdf'])->name('anggota.export-pdf');
    Route::resource('surat', PacSurat::class);
    Route::resource('agenda', PacAgenda::class);
});

Route::middleware(['auth', 'profile.complete', 'role:admin_pr'])->prefix('admin-pr')->name('admin_pr.')->group(function () {
    Route::get('/dashboard', [PrDashboard::class, 'index'])->name('dashboard');
    Route::resource('anggota', PrAnggota::class);
    Route::resource('surat', PrSurat::class);
    Route::resource('agenda', PrAgenda::class);
});

Route::middleware(['auth', 'profile.complete', 'role:anggota'])->prefix('anggota')->name('anggota.')->group(function () {
    Route::get('/dashboard', [AnggotaDashboard::class, 'index'])->name('dashboard');
    Route::get('/profile/edit', [\App\Http\Controllers\Anggota\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\Anggota\ProfileController::class, 'update'])->name('profile.update');
    Route::resource('pengkaderan', \App\Http\Controllers\Anggota\PengkaderanController::class);
});

Route::get('/desa/{kecamatan_id}', function ($kecamatan_id) {
    return \App\Models\Desa::where('kecamatan_id', $kecamatan_id)->get(['id', 'nama']);
});
require __DIR__ . '/auth.php';
