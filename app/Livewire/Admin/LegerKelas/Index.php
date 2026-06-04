<?php

namespace App\Livewire\Admin\LegerKelas;

use Livewire\Component;
use App\Models\KelasRapor;
use App\Models\Semester;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Exports\LegerKelasExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    public $kelasId;
    public $semesterId;
    public $kelas;
    public $semester;
    public $mataPelajarans = [];
    public $legerData = [];
    public $averages = [];
    public $rankings = [];

    public function mount()
    {
        // Get active semester
        $this->semester = Semester::where('is_active', true)->first();
        $this->semesterId = $this->semester->id ?? null;
    }

    public function loadLegerData()
    {
        if (!$this->kelasId || !$this->semesterId) {
            $this->legerData = [];
            $this->mataPelajarans = [];
            $this->averages = [];
            $this->rankings = [];
            return;
        }

        $this->kelas = KelasRapor::with('tahunAjaran')->find($this->kelasId);

        if (!$this->kelas) {
            $this->legerData = [];
            $this->mataPelajarans = [];
            $this->averages = [];
            $this->rankings = [];
            return;
        }

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
            ->where('kelas_siswa.kelas_id', $this->kelasId)
            ->select('siswas_rapor.*', 'kelas_siswa.nomor_absen')
            ->orderBy('siswas_rapor.nama')
            ->get();

        // Get all nilais for this class and semester
        $nilais = Nilai::where('kelas_id', $this->kelasId)
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
                'nama_arabic' => $siswa->nama_arabic,
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

    public function updatedKelasId()
    {
        $this->loadLegerData();
    }

    public function updatedSemesterId()
    {
        $this->semester = Semester::find($this->semesterId);
        $this->loadLegerData();
    }

    public function export()
    {
        if (!$this->kelasId || !$this->semesterId) {
            session()->flash('error', 'Silakan pilih kelas dan semester terlebih dahulu.');
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
        $kelasList = KelasRapor::with('tahunAjaran')->orderBy('nama')->get();
        $semesters = Semester::orderBy('tahun_ajaran_id', 'desc')->orderBy('nama')->get();

        return view('livewire.admin.leger-kelas.index', [
            'kelasList' => $kelasList,
            'semesters' => $semesters
        ])->layout('layouts.app', ['title' => 'Leger Kelas']);
    }
}
