<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;

// Public routes
Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

// Auth routes (handled by Fortify)
require __DIR__.'/settings.php';

// Protected routes
Route::middleware(['auth'])->group(function () {
    
    // Dashboard (all roles)
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    
    // Admin routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        
        // Tahun Ajaran
        Route::prefix('tahun-ajaran')->name('tahun-ajaran.')->group(function () {
            Route::get('/', \App\Livewire\Admin\TahunAjaran\Index::class)->name('index');
            Route::get('/create', \App\Livewire\Admin\TahunAjaran\Create::class)->name('create');
            Route::get('/{id}/edit', \App\Livewire\Admin\TahunAjaran\Edit::class)->name('edit');
        });
        
        // Kelas
        Route::prefix('kelas')->name('kelas.')->group(function () {
            Route::get('/', \App\Livewire\Admin\Kelas\Index::class)->name('index');
            Route::get('/create', \App\Livewire\Admin\Kelas\Create::class)->name('create');
            Route::get('/{id}/edit', \App\Livewire\Admin\Kelas\Edit::class)->name('edit');
            Route::get('/{kelasId}/manage-siswa', \App\Livewire\Admin\Kelas\ManageSiswa::class)->name('manage-siswa');
        });
        
        // Siswa
        Route::prefix('siswa')->name('siswa.')->group(function () {
            Route::get('/', \App\Livewire\Admin\Siswa\Index::class)->name('index');
            Route::get('/create', \App\Livewire\Admin\Siswa\Create::class)->name('create');
            Route::get('/{id}/view', \App\Livewire\Admin\Siswa\View::class)->name('view');
            Route::get('/{id}/edit', \App\Livewire\Admin\Siswa\Edit::class)->name('edit');
        });
        
        
        
        // Guru
        Route::prefix('guru')->name('guru.')->group(function () {
            Route::get('/', \App\Livewire\Admin\Guru\Index::class)->name('index');
            Route::get('/create', \App\Livewire\Admin\Guru\Create::class)->name('create');
            Route::get('/{id}/edit', \App\Livewire\Admin\Guru\Edit::class)->name('edit');
        });
        
        
        // Mata Pelajaran
        Route::prefix('mata-pelajaran')->name('mata-pelajaran.')->group(function () {
            Route::get('/', \App\Livewire\Admin\MataPelajaran\Index::class)->name('index');
            Route::get('/create', \App\Livewire\Admin\MataPelajaran\Create::class)->name('create');
            Route::get('/{id}/edit', \App\Livewire\Admin\MataPelajaran\Edit::class)->name('edit');
        });
        

        // Rapor
        Route::prefix('rapor')->name('rapor.')->group(function () {
            Route::get('/', \App\Livewire\Admin\Rapor\Index::class)->name('index');
            Route::get('/{siswaId}/preview', \App\Livewire\Admin\Rapor\Preview::class)->name('preview');
            Route::get('/{siswaId}/print', [\App\Livewire\Admin\Rapor\Preview::class, 'print'])->name('print');
            Route::get('/print-all-class', [\App\Livewire\Admin\Rapor\Index::class, 'printAllByClass'])->name('print-all-class');
        });
        
        
        // Leger Kelas
        Route::prefix('leger-kelas')->name('leger-kelas.')->group(function () {
            Route::get('/', \App\Livewire\Admin\LegerKelas\Index::class)->name('index');
        });
        
        // Rapor Settings
        Route::get('/rapor-settings', \App\Livewire\Admin\RaporSettings\Edit::class)->name('rapor-settings.edit');
    });
    
    
    // Guru routes
    Route::middleware(['role:guru,wali_kelas'])->prefix('guru')->name('guru.')->group(function () {
        Route::prefix('input-nilai')->name('input-nilai.')->group(function () {
            Route::get('/', \App\Livewire\Guru\InputNilai\Index::class)->name('index');
            Route::get('/{kelasId}/{mataPelajaranId?}', \App\Livewire\Guru\InputNilai\Form::class)->name('form');
        });
    });
    
    
    // Wali Kelas routes
    Route::middleware(['role:wali_kelas,guru'])->prefix('wali-kelas')->name('wali-kelas.')->group(function () {
        // Kehadiran
        Route::prefix('kehadiran')->name('kehadiran.')->group(function () {
            Route::get('/', \App\Livewire\WaliKelas\Kehadiran\Index::class)->name('index');
            Route::get('/{siswaId}/{semesterId?}', \App\Livewire\WaliKelas\Kehadiran\Form::class)->name('form');
        });
        
        // Catatan
        Route::prefix('catatan')->name('catatan.')->group(function () {
            Route::get('/', \App\Livewire\WaliKelas\Catatan\Index::class)->name('index');
            Route::get('/{siswaId}/{semesterId?}', \App\Livewire\WaliKelas\Catatan\Form::class)->name('form');
        });
            
        Route::prefix('rapor')->name('rapor.')->group(function () {
            Route::get('/', \App\Livewire\WaliKelas\Rapor\Index::class)->name('index');
            Route::get('/{siswaId}/preview', \App\Livewire\WaliKelas\Rapor\Preview::class)->name('preview');
            Route::get('/{siswaId}/print', [\App\Livewire\WaliKelas\Rapor\Preview::class, 'print'])->name('print');
            Route::get('/print-all-class', [\App\Livewire\WaliKelas\Rapor\Index::class, 'printAllByClass'])->name('print-all-class');
        });
        
        // Leger Kelas
        Route::prefix('leger-kelas')->name('leger-kelas.')->group(function () {
            Route::get('/', \App\Livewire\WaliKelas\LegerKelas\Index::class)->name('index');
        });
    });
});
