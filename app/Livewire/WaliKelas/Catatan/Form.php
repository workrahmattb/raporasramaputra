<?php

namespace App\Livewire\WaliKelas\Catatan;

use Livewire\Component;
use App\Models\CatatanWaliKelas;
use App\Models\SiswaRapor;
use App\Models\Semester;
use App\Models\KelasRapor;
use App\Models\GuruRapor;

class Form extends Component
{
    public $siswaId;
    public $semesterId;
    public $siswa;
    public $semester;
    public $kelas;
    public $catatan = '';

    protected $rules = [
        'catatan' => 'required|string|max:1000',
    ];

    protected $messages = [
        'catatan.required' => 'Catatan wali kelas harus diisi',
        'catatan.string' => 'Catatan harus berupa teks',
        'catatan.max' => 'Catatan maksimal 1000 karakter',
    ];

    public function mount($siswaId, $semesterId = null)
    {
        $this->siswaId = $siswaId;
        $this->siswa = SiswaRapor::findOrFail($siswaId);
        
        // Get active semester if not provided
        if ($semesterId) {
            $this->semesterId = $semesterId;
            $this->semester = Semester::findOrFail($semesterId);
        } else {
            $this->semester = Semester::where('status', 'Aktif')->first();
            $this->semesterId = $this->semester->id ?? null;
        }

        // Get kelas from kelas_siswa pivot
        $kelasData = \DB::table('kelas_siswa')
            ->join('kelas_rapor', 'kelas_siswa.kelas_id', '=', 'kelas_rapor.id')
            ->where('kelas_siswa.siswa_id', $this->siswaId)
            ->select('kelas_rapor.*')
            ->first();

        $this->kelas = $kelasData;

        // Load existing catatan data
        $this->loadCatatan();
    }

    public function loadCatatan()
    {
        if (!$this->semesterId) return;

        $catatan = CatatanWaliKelas::where('siswa_id', $this->siswaId)
            ->where('semester_id', $this->semesterId)
            ->first();

        if ($catatan) {
            $this->catatan = $catatan->catatan;
        }
    }

    public function getCharacterCountProperty()
    {
        return strlen($this->catatan);
    }

    public function save()
    {
        $this->validate();

        // Get wali kelas guru_rapor id
        $waliKelas = GuruRapor::where('user_id', auth()->id())->first();

        if (!$waliKelas) {
            session()->flash('error', 'Anda tidak terdaftar sebagai guru.');
            return;
        }

        CatatanWaliKelas::updateOrCreate(
            [
                'siswa_id' => $this->siswaId,
                'semester_id' => $this->semesterId,
            ],
            [
                'wali_kelas_id' => $waliKelas->id,
                'catatan' => $this->catatan,
            ]
        );

        session()->flash('message', 'Catatan wali kelas berhasil disimpan.');
        
        return redirect()->route('wali-kelas.catatan.index');
    }

    public function render()
    {
        return view('livewire.wali-kelas.catatan.form')
            ->layout('layouts.app', ['title' => 'Input Catatan Wali Kelas']);
    }
}
