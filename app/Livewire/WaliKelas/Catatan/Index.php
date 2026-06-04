<?php

namespace App\Livewire\WaliKelas\Catatan;

use Livewire\Component;
use App\Models\KelasRapor;
use App\Models\Semester;
use App\Models\CatatanWaliKelas;

class Index extends Component
{
    public $semesterId;
    public $kelas;
    public $siswas = [];

    public function mount()
    {
        // Get kelas where current user is wali kelas
        $this->kelas = KelasRapor::whereHas('waliKelas', function($query) {
            $query->where('user_id', auth()->id());
        })->with('tahunAjaran')->first();

        // Get active semester
        $activeSemester = Semester::where('is_active', true)->first();
        $this->semesterId = $activeSemester->id ?? null;

        if ($this->kelas && $this->semesterId) {
            $this->loadSiswas();
        }
    }

    public function loadSiswas()
    {
        if (!$this->kelas || !$this->semesterId) {
            $this->siswas = [];
            return;
        }

        // Get students in this class via kelas_siswa pivot with catatan data
        $this->siswas = \DB::table('kelas_siswa')
            ->join('siswas_rapor', 'kelas_siswa.siswa_id', '=', 'siswas_rapor.id')
            ->leftJoin('catatan_wali_kelas', function($join) {
                $join->on('siswas_rapor.id', '=', 'catatan_wali_kelas.siswa_id')
                     ->where('catatan_wali_kelas.semester_id', '=', $this->semesterId);
            })
            ->where('kelas_siswa.kelas_id', $this->kelas->id)
            ->select(
                'siswas_rapor.*', 
                'kelas_siswa.nomor_absen',
                'catatan_wali_kelas.catatan'
            )
            ->orderBy('kelas_siswa.nomor_absen')
            ->get();
    }

    public function updatedSemesterId()
    {
        $this->loadSiswas();
    }

    public function render()
    {
        $semesters = Semester::orderBy('tahun_ajaran_id', 'desc')->orderBy('jenis')->get();

        return view('livewire.wali-kelas.catatan.index', [
            'semesters' => $semesters
        ])->layout('layouts.app', ['title' => 'Input Catatan Wali Kelas']);
    }
}
