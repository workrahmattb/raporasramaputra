<?php

namespace App\Livewire\Guru\InputNilai;

use Livewire\Component;
use App\Models\Nilai;
use App\Models\KelasRapor;
use App\Models\MataPelajaran;
use App\Models\Semester;
use Illuminate\Support\Facades\DB;

class Form extends Component
{
    public $kelasId;
    public $mataPelajaranId;
    public $semesterId;
    public $kelas;
    public $mataPelajaran;
    public $semester;
    public $nilaiData = [];

    protected $rules = [
        'nilaiData.*.nilai_pengetahuan' => 'nullable|numeric|min:0|max:100',
    ];

    public function mount($kelasId, $mataPelajaranId = null)
    {
        $this->kelasId = $kelasId;
        $this->mataPelajaranId = $mataPelajaranId;
        
        $this->kelas = KelasRapor::findOrFail($kelasId);
        
        // Get active semester
        $this->semester = Semester::where('is_active', true)->first();
        
        // Validate that an active semester exists
        if (!$this->semester) {
            session()->flash('error', 'Tidak ada semester aktif. Silakan hubungi admin untuk mengaktifkan semester.');
            $this->redirectRoute('guru.input-nilai.index', navigate: true);
            return;
        }
        
        $this->semesterId = $this->semester->id;

        // If no subject selected yet, just show the page without loading grades
        if (!$this->mataPelajaranId) {
            return;
        }

        $this->mataPelajaran = MataPelajaran::findOrFail($mataPelajaranId);
        $this->loadNilaiData();
    }

    public function updatedMataPelajaranId($value)
    {
        if ($value) {
            $this->mataPelajaran = MataPelajaran::findOrFail($value);
            $this->loadNilaiData();
        } else {
            $this->mataPelajaran = null;
            $this->nilaiData = [];
        }
    }

    public function loadNilaiData()
    {
        // Get all students in this class via kelas_siswa pivot
        $siswas = DB::table('kelas_siswa')
            ->join('siswas_rapor', 'kelas_siswa.siswa_id', '=', 'siswas_rapor.id')
            ->where('kelas_siswa.kelas_id', $this->kelasId)
            ->select('siswas_rapor.*', 'kelas_siswa.nomor_absen')
            ->orderBy('kelas_siswa.nomor_absen')
            ->get();

        foreach ($siswas as $siswa) {
            // Check if nilai already exists
            $nilai = Nilai::where('siswa_id', $siswa->id)
                ->where('kelas_id', $this->kelasId)
                ->where('mata_pelajaran_id', $this->mataPelajaranId)
                ->where('semester_id', $this->semesterId)
                ->first();

            $this->nilaiData[$siswa->id] = [
                'siswa_id' => $siswa->id,
                'nama' => $siswa->nama,
                'nomor_absen' => $siswa->nomor_absen,
                'nilai_pengetahuan' => $nilai->nilai_pengetahuan ?? '',
            ];
        }
    }

    public function save()
    {
        if (!$this->mataPelajaranId) {
            session()->flash('error', 'Silakan pilih mata pelajaran terlebih dahulu.');
            return;
        }

        $this->validate();

        $guru = auth()->user()->guruProfile;

        foreach ($this->nilaiData as $siswaId => $data) {
            // Only save if nilai is filled
            if (!empty($data['nilai_pengetahuan'])) {
                Nilai::updateOrCreate(
                    [
                        'siswa_id' => $siswaId,
                        'kelas_id' => $this->kelasId,
                        'mata_pelajaran_id' => $this->mataPelajaranId,
                        'semester_id' => $this->semesterId,
                    ],
                    [
                        'guru_id' => $guru?->id,
                        'nilai_pengetahuan' => $data['nilai_pengetahuan'] ?: null,
                    ]
                );
            }
        }

        session()->flash('message', 'Nilai berhasil disimpan.');
        $this->loadNilaiData(); // Reload to show saved data
    }

    public function render()
    {
        $allMapels = MataPelajaran::where('sekolah_id', auth()->user()->sekolah_id)
            ->orderBy('nama')
            ->get();

        return view('livewire.guru.input-nilai.form', [
            'allMapels' => $allMapels,
        ])->layout('layouts.app', ['title' => 'Input Nilai']);
    }
}
