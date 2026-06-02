<?php

namespace App\Livewire\WaliKelas\Kehadiran;

use Livewire\Component;
use App\Models\Kehadiran;
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
    public $sakit = 0;
    public $izin = 0;
    public $tanpa_keterangan = 0;

    protected $rules = [
        'sakit' => 'required|integer|min:0',
        'izin' => 'required|integer|min:0',
        'tanpa_keterangan' => 'required|integer|min:0',
    ];

    protected $messages = [
        'sakit.required' => 'Jumlah sakit harus diisi',
        'sakit.integer' => 'Jumlah sakit harus berupa angka',
        'sakit.min' => 'Jumlah sakit tidak boleh kurang dari 0',
        'izin.required' => 'Jumlah izin harus diisi',
        'izin.integer' => 'Jumlah izin harus berupa angka',
        'izin.min' => 'Jumlah izin tidak boleh kurang dari 0',
        'tanpa_keterangan.required' => 'Jumlah tanpa keterangan harus diisi',
        'tanpa_keterangan.integer' => 'Jumlah tanpa keterangan harus berupa angka',
        'tanpa_keterangan.min' => 'Jumlah tanpa keterangan tidak boleh kurang dari 0',
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

        // Load existing kehadiran data
        $this->loadKehadiran();
    }

    public function loadKehadiran()
    {
        if (!$this->semesterId) return;

        $kehadiran = Kehadiran::where('siswa_id', $this->siswaId)
            ->where('semester_id', $this->semesterId)
            ->first();

        if ($kehadiran) {
            $this->sakit = $kehadiran->sakit;
            $this->izin = $kehadiran->izin;
            $this->tanpa_keterangan = $kehadiran->tanpa_keterangan;
        }
    }

    public function getTotalAbsenProperty()
    {
        return (int)$this->sakit + (int)$this->izin + (int)$this->tanpa_keterangan;
    }

    public function save()
    {
        $this->validate();

        Kehadiran::updateOrCreate(
            [
                'siswa_id' => $this->siswaId,
                'semester_id' => $this->semesterId,
            ],
            [
                'sakit' => $this->sakit,
                'izin' => $this->izin,
                'tanpa_keterangan' => $this->tanpa_keterangan,
            ]
        );

        session()->flash('message', 'Data kehadiran berhasil disimpan.');
        
        return redirect()->route('wali-kelas.kehadiran.index');
    }

    public function render()
    {
        return view('livewire.wali-kelas.kehadiran.form')
            ->layout('layouts.app', ['title' => 'Input Kehadiran']);
    }
}
