<?php

namespace App\Livewire\Guru\InputNilai;

use Livewire\Component;
use App\Models\Nilai;
use App\Models\SiswaRapor;
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
        'nilaiData.*.nilai_keterampilan' => 'nullable|numeric|min:0|max:100',
    ];

    public function mount($kelasId, $mataPelajaranId)
    {
        $this->kelasId = $kelasId;
        $this->mataPelajaranId = $mataPelajaranId;
        
        $this->kelas = KelasRapor::findOrFail($kelasId);
        $this->mataPelajaran = MataPelajaran::findOrFail($mataPelajaranId);
        
        // Get active semester
        $this->semester = Semester::where('is_active', true)->first();
        
        // Validate that an active semester exists
        if (!$this->semester) {
            session()->flash('error', 'Tidak ada semester aktif. Silakan hubungi admin untuk mengaktifkan semester.');
            return redirect()->route('guru.input-nilai.index');
        }
        
        $this->semesterId = $this->semester->id;
        
        $this->loadNilaiData();
    }

    public function loadNilaiData()
    {
        // Get all students in this class via kelas_siswa pivot
        $siswas = DB::table('kelas_siswa')
            ->join('siswas_rapor', 'kelas_siswa.siswa_id', '=', 'siswas_rapor.id')
            ->where('kelas_siswa.kelas_id', $this->kelasId)
            ->select('siswas_rapor.*', 'kelas_siswa.nomor_absen')
            ->orderBy('siswas_rapor.nama', 'asc')
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
                'nilai_keterampilan' => $nilai->nilai_keterampilan ?? '',
            ];
        }
    }

    public function save()
    {
        $this->validate();

        $guruId = auth()->user()->guruProfile->id ?? null;

        foreach ($this->nilaiData as $siswaId => $data) {
            // Only save if at least one nilai is filled
            if (!empty($data['nilai_pengetahuan']) || !empty($data['nilai_keterampilan'])) {
                Nilai::updateOrCreate(
                    [
                        'siswa_id' => $siswaId,
                        'kelas_id' => $this->kelasId,
                        'mata_pelajaran_id' => $this->mataPelajaranId,
                        'semester_id' => $this->semesterId,
                    ],
                    [
                        'guru_id' => $guruId,
                        'nilai_pengetahuan' => $data['nilai_pengetahuan'] ?: null,
                        'nilai_keterampilan' => $data['nilai_keterampilan'] ?: null,
                    ]
                );
            }
        }

        session()->flash('message', 'Nilai berhasil disimpan.');
        $this->loadNilaiData(); // Reload to show saved data
    }

    public function render()
    {
        return view('livewire.guru.input-nilai.form')->layout('layouts.app', ['title' => 'Input Nilai']);
    }
}
