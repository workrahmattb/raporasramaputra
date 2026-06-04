<?php

namespace App\Livewire\WaliKelas\LegerKelas;

use Livewire\Component;
use App\Models\KelasRapor;
use App\Models\Semester;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\GuruRapor;
use App\Exports\LegerKelasExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    public $semesterId;
    public $kelas;
    public $semester;
    public $mataPelajarans = [];
    public $legerData = [];
    public $averages = [];
    public $rankings = [];

    public function mount()
    {
        // Get kelas where current user is wali kelas
        $this->kelas = KelasRapor::whereHas('waliKelas', function($query) {
            $query->where('user_id', auth()->id());
        })->with('tahunAjaran')->first();

        if (!$this->kelas) {
            session()->flash('error', 'Anda tidak ditugaskan sebagai wali kelas.');
            return;
        }

        // Get active semester or specific semester if ID is set
        if ($this->semesterId) {
            $this->semester = Semester::find($this->semesterId);
        } else {
            $this->semester = Semester::where('is_active', true)->first();
            $this->semesterId = $this->semester->id ?? null;
        }

        if ($this->kelas && $this->semesterId) {
            $this->loadLegerData();
        }
    }

    public function loadLegerData()
    {
        if (!$this->kelas || !$this->semesterId) {
            $this->legerData = [];
            $this->mataPelajarans = [];
            $this->averages = [];
            $this->rankings = [];
            return;
        }

        // Get all mata pelajaran taught in this class (by tingkat)
        // Reset averages and rankings to prevent leaking data from previous class selection
        $this->averages = [];
        $this->rankings = [];

        // Get all mata pelajaran
        $this->mataPelajarans = MataPelajaran::where('sekolah_id', auth()->user()->sekolah_id)
            ->orderBy('nama')
            ->get();

        // Get all students in this class
        $siswas = DB::table('kelas_siswa')
            ->join('siswas_rapor', 'kelas_siswa.siswa_id', '=', 'siswas_rapor.id')
            ->where('kelas_siswa.kelas_id', $this->kelas->id)
            ->select('siswas_rapor.*', 'kelas_siswa.nomor_absen')
            ->orderBy('siswas_rapor.nama')
            ->get();

        // Get all nilais for this class and semester
        $nilais = Nilai::where('kelas_id', $this->kelas->id)
            ->where('semester_id', $this->semesterId)
            ->get()
            ->groupBy('siswa_id');

        // Build leger data structure
        $this->legerData = [];
        foreach ($siswas as $siswa) {
            $siswaData = [
                'id' => $siswa->id,
                'nomor_absen' => $siswa->nomor_absen,
                'nama' => $siswa->nama,
                'grades' => [],
            ];

            $totalNilai = 0;
            $countNilai = 0;

            foreach ($this->mataPelajarans as $mapel) {
                $nilai = $nilais->get($siswa->id)?->firstWhere('mata_pelajaran_id', $mapel->id);
                $nilaiPengetahuan = $nilai->nilai_pengetahuan ?? null;
                
                $siswaData['grades'][$mapel->id] = $nilaiPengetahuan;

                // Calculate average (only count non-empty grades)
                if ($nilaiPengetahuan !== null && $nilaiPengetahuan > 0) {
                    $totalNilai += $nilaiPengetahuan;
                    $countNilai++;
                }
            }

            // Store total and calculate average
            $siswaData['total'] = $totalNilai;
            $siswaData['average'] = $countNilai > 0 ? round($totalNilai / $countNilai, 2) : 0;
            $this->averages[$siswa->id] = $siswaData['average'];

            $this->legerData[] = $siswaData;
        }

        // Calculate rankings
        $this->calculateRankings();
    }

    public function calculateRankings()
    {
        // Sort averages in descending order
        $sortedAverages = $this->averages;
        arsort($sortedAverages);

        $rank = 1;
        $previousAverage = null;
        $sameRankCount = 0;

        foreach ($sortedAverages as $siswaId => $average) {
            if ($average == 0) {
                // Students with 0 average don't get ranked
                $this->rankings[$siswaId] = '-';
                continue;
            }

            if ($previousAverage !== null && $average < $previousAverage) {
                $rank += $sameRankCount;
                $sameRankCount = 1;
            } else {
                $sameRankCount++;
            }

            $this->rankings[$siswaId] = $rank;
            $previousAverage = $average;
        }

        // Update leger data with rankings
        foreach ($this->legerData as &$siswa) {
            $siswa['ranking'] = $this->rankings[$siswa['id']] ?? '-';
        }
    }

    public function updatedSemesterId()
    {
        $this->semester = Semester::find($this->semesterId);
        $this->loadLegerData();
    }

    public function export()
    {
        if (!$this->kelas || !$this->semesterId) {
            session()->flash('error', 'Data tidak lengkap untuk export.');
            return;
        }

        $fileName = 'Leger_Kelas_' . str_replace(' ', '_', $this->kelas->nama) . '_' . 
                    str_replace('/', '-', $this->semester->nama) . '_' . 
                    date('Y-m-d') . '.xlsx';

        return Excel::download(
            new LegerKelasExport(
                $this->kelas,
                $this->semester,
                $this->mataPelajarans,
                $this->legerData
            ),
            $fileName
        );
    }

    public function render()
    {
        $semesters = Semester::orderBy('tahun_ajaran_id', 'desc')->orderBy('nama')->get();

        return view('livewire.wali-kelas.leger-kelas.index', [
            'semesters' => $semesters
        ])->layout('layouts.app', ['title' => 'Leger Kelas']);
    }
}
