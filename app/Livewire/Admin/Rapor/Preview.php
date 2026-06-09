<?php

namespace App\Livewire\Admin\Rapor;

use Livewire\Component;
use App\Models\SiswaRapor;
use App\Models\Semester;
use App\Models\Nilai;
use App\Models\NilaiSikap;
use App\Models\Kehadiran;
use App\Models\CatatanWaliKelas;
use App\Models\RaporSetting;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf;

class Preview extends Component
{
    public $siswaId;
    public $semesterId;
    public $siswa;
    public $semester;
    public $kelas;
    public $nilais = [];
    public $nilaiSikap;
    public $kehadiran;
    public $catatan;

    public function mount($siswaId, $semesterId = null)
    {
        $this->siswaId = $siswaId;
        $this->siswa = SiswaRapor::findOrFail($siswaId);
        
        // Get active semester if not provided
        if ($semesterId) {
            $this->semesterId = $semesterId;
            $this->semester = Semester::with('tahunAjaran')->findOrFail($semesterId);
        } else {
            $this->semester = Semester::with('tahunAjaran')->where('is_active', true)->first();
            $this->semesterId = $this->semester->id ?? null;
        }

        // Get kelas from kelas_siswa pivot using Eloquent to allow relationship access
        $kelasId = \DB::table('kelas_siswa')
            ->where('siswa_id', $this->siswaId)
            ->value('kelas_id');

        if ($kelasId) {
            $this->kelas = \App\Models\KelasRapor::with('waliKelas')->find($kelasId);
        }

        $this->loadNilais();
        $this->loadNilaiSikap();
        $this->loadKehadiran();
        $this->loadCatatan();
    }

    public function loadNilais()
    {
        if (!$this->semesterId) return;

        $this->nilais = Nilai::where('siswa_id', $this->siswaId)
            ->where('semester_id', $this->semesterId)
            ->with('mataPelajaran')
            ->get();
    }

    public function loadNilaiSikap()
    {
        if (!$this->semesterId) return;

        $this->nilaiSikap = NilaiSikap::where('siswa_id', $this->siswaId)
            ->where('semester_id', $this->semesterId)
            ->first();
    }

    public function loadKehadiran()
    {
        if (!$this->semesterId) return;

        $this->kehadiran = Kehadiran::where('siswa_id', $this->siswaId)
            ->where('semester_id', $this->semesterId)
            ->first();
    }

    public function loadCatatan()
    {
        if (!$this->semesterId) return;

        $this->catatan = CatatanWaliKelas::where('siswa_id', $this->siswaId)
            ->where('semester_id', $this->semesterId)
            ->first();
    }

    public function print($siswaId)
    {
        $semesterId = request()->query('semesterId');
        $this->mount($siswaId, $semesterId);
        
        // Load rapor settings
        $settings = RaporSetting::getSettings();

        $pdf = LaravelMpdf::loadView('livewire.admin.rapor.print', [
            'siswa' => $this->siswa,
            'semester' => $this->semester,
            'kelas' => $this->kelas,
            'nilais' => $this->nilais,
            'nilaiSikap' => $this->nilaiSikap,
            'kehadiran' => $this->kehadiran,
            'catatan' => $this->catatan,
            'settings' => $settings,
        ], [], [
            'format' => [215, 330], // F4 size
            'orientation' => 'P',
        ]);

        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="rapor-' . $this->siswa->nama . '-' . $this->semester->nama . '.pdf"',
            'Cache-Control' => 'no-cache, must-revalidate',
        ]);
    }

    public function render()
    {
        return view('livewire.admin.rapor.preview')
            ->layout('layouts.app', ['title' => 'Preview Rapor']);
    }
}
