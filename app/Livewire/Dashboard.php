<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TahunAjaran;
use App\Models\Semester;
use App\Models\SiswaRapor;
use App\Models\GuruRapor;
use App\Models\KelasRapor;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public function render()
    {
        $user = auth()->user();
        
        $stats = [];
        
        if ($user->isAdmin()) {
            $stats = [
                'tahun_ajaran_aktif' => TahunAjaran::active()->first(),
                'semester_aktif' => Semester::active()->first(),
                'total_siswa' => SiswaRapor::where('sekolah_id', $user->sekolah_id)->active()->count(),
                'total_guru' => GuruRapor::where('sekolah_id', $user->sekolah_id)->active()->count(),
                'total_kelas' => KelasRapor::whereHas('tahunAjaran', function($q) {
                    $q->where('is_active', true);
                })->count(),
            ];
        } elseif ($user->isGuru()) {
            $guru = $user->guruProfile;
            $stats = [
                'tahun_ajaran_aktif' => TahunAjaran::active()->first(),
                'semester_aktif' => Semester::active()->first(),
                'total_kelas' => $guru ? DB::table('guru_mata_pelajaran')
                    ->where('guru_id', $guru->id)
                    ->distinct('tingkat')
                    ->count('tingkat') : 0,
            ];
        } elseif ($user->isWaliKelas()) {
            $stats = [
                'tahun_ajaran_aktif' => TahunAjaran::active()->first(),
                'semester_aktif' => Semester::active()->first(),
                'kelas_wali' => $user->kelasWali()->whereHas('tahunAjaran', function($q) {
                    $q->where('is_active', true);
                })->get(),
            ];
        }
        
        return view('livewire.dashboard', compact('stats'));
    }
}
