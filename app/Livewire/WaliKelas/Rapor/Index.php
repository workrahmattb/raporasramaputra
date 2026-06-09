<?php

namespace App\Livewire\WaliKelas\Rapor;

use Livewire\Component;
use App\Models\KelasRapor;
use App\Models\Semester;

class Index extends Component
{
    public $semesterId;
    public $semester;
    public $kelas;
    public $siswas = [];
    public $catatan = [];

    public function mount()
    {
        // Get kelas where current user is wali kelas
        $this->kelas = KelasRapor::whereHas('waliKelas', function($query) {
            $query->where('user_id', auth()->id());
        })->with('tahunAjaran')->first();

        // Get active semester or specific semester if ID is set
        if ($this->semesterId) {
            $this->semester = Semester::find($this->semesterId);
        } else {
            $this->semester = Semester::where('is_active', true)->first();
            $this->semesterId = $this->semester->id ?? null;
        }

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

        // Get students in this class via kelas_siswa pivot
        $this->siswas = \DB::table('kelas_siswa')
            ->join('siswas_rapor', 'kelas_siswa.siswa_id', '=', 'siswas_rapor.id')
            ->where('kelas_siswa.kelas_id', $this->kelas->id)
            ->select('siswas_rapor.*', 'kelas_siswa.nomor_absen')
            ->orderBy('kelas_siswa.nomor_absen')
            ->get();

        // Load existing catatan
        $catatans = \App\Models\CatatanWaliKelas::where('semester_id', $this->semesterId)
            ->whereIn('siswa_id', $this->siswas->pluck('id'))
            ->get();

        foreach ($this->siswas as $siswa) {
            $note = $catatans->firstWhere('siswa_id', $siswa->id);
            $this->catatan[$siswa->id] = $note ? $note->catatan : '';
        }
    }

    public function updatedSemesterId()
    {
        $this->loadSiswas();
    }

    public function updatedCatatan($value, $siswaId)
    {
        if (!$this->semesterId) return;

        // Ensure we have the wali kelas ID (Guru ID)
        $guru = \App\Models\GuruRapor::where('user_id', auth()->id())->first();
        if (!$guru) return;

        \App\Models\CatatanWaliKelas::updateOrCreate(
            [
                'siswa_id' => $siswaId,
                'semester_id' => $this->semesterId,
            ],
            [
                'wali_kelas_id' => $guru->id,
                'catatan' => $value
            ]
        );

        $this->dispatch('saved-catatan');
    }

    public function printAllByClass()
    {
        // Get semesterId from query string
        $semesterId = request()->query('semesterId');
        
        // Load kelas if not already loaded
        $kelas = KelasRapor::whereHas('waliKelas', function($query) {
            $query->where('user_id', auth()->id());
        })->with('tahunAjaran')->first();
        
        if (!$kelas || !$semesterId) {
            abort(400, 'Pilih kelas dan semester terlebih dahulu');
        }

        // Verify this user is indeed the wali kelas for this class
        $guru = \App\Models\GuruRapor::where('user_id', auth()->id())->first();
        if (!$guru || $kelas->wali_kelas_id != $guru->id) {
            abort(403, 'Anda bukan wali kelas kelas ini');
        }

        // Get all students in the selected class
        $siswas = \DB::table('kelas_siswa')
            ->join('siswas_rapor', 'kelas_siswa.siswa_id', '=', 'siswas_rapor.id')
            ->where('kelas_siswa.kelas_id', $kelas->id)
            ->orderBy('kelas_siswa.nomor_absen')
            ->get();

        if ($siswas->isEmpty()) {
            abort(404, 'Tidak ada siswa di kelas ini');
        }

        $semester = Semester::with('tahunAjaran')->find($semesterId);
        $settings = \App\Models\RaporSetting::getSettings();

        // Prepare data for all students
        $allRaporData = [];
        foreach ($siswas as $siswa) {
            $nilais = \App\Models\Nilai::where('siswa_id', $siswa->id)
                ->where('semester_id', $semesterId)
                ->with('mataPelajaran')
                ->get();

            $nilaiSikap = \App\Models\NilaiSikap::where('siswa_id', $siswa->id)
                ->where('semester_id', $semesterId)
                ->first();

            $kehadiran = \App\Models\Kehadiran::where('siswa_id', $siswa->id)
                ->where('semester_id', $semesterId)
                ->first();

            $catatan = \App\Models\CatatanWaliKelas::where('siswa_id', $siswa->id)
                ->where('semester_id', $semesterId)
                ->first();

            $allRaporData[] = [
                'siswa' => $siswa,
                'nilais' => $nilais,
                'nilaiSikap' => $nilaiSikap,
                'kehadiran' => $kehadiran,
                'catatan' => $catatan,
            ];
        }

        // Generate PDF with all students - use admin's print-all view
        $pdf = \Mccarlosen\LaravelMpdf\Facades\LaravelMpdf::loadView('livewire.admin.rapor.print-all', [
            'allRaporData' => $allRaporData,
            'kelas' => $kelas,
            'semester' => $semester,
            'settings' => $settings,
        ], [], [
            'format' => [215, 330], // F4 size
            'orientation' => 'P',
        ]);

        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="rapor-' . $kelas->nama . '-' . $semester->nama . '.pdf"',
            'Cache-Control' => 'no-cache, must-revalidate',
        ]);
    }

    public function render()
    {
        $semesters = Semester::orderBy('tahun_ajaran_id', 'desc')->orderBy('nama')->get();

        return view('livewire.wali-kelas.rapor.index', [
            'semesters' => $semesters
        ])->layout('layouts.app', ['title' => 'Cetak Rapor']);
    }
}
