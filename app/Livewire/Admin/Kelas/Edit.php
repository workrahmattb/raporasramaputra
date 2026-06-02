<?php

namespace App\Livewire\Admin\Kelas;

use Livewire\Component;
use App\Models\KelasRapor;
use App\Models\TahunAjaran;
use App\Models\GuruRapor;

class Edit extends Component
{
    public $kelasId;
    public $tahun_ajaran_id = '';
    public $wali_kelas_id = '';
    public $nama = '';
    public $tingkat = '';

    protected $rules = [
        'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
        'wali_kelas_id' => 'nullable|exists:gurus_rapor,id',
        'nama' => 'required|string|max:255',
        'tingkat' => 'required|integer|min:1|max:12',
    ];

    protected $messages = [
        'tahun_ajaran_id.required' => 'Tahun ajaran harus dipilih',
        'nama.required' => 'Nama kelas harus diisi',
        'tingkat.required' => 'Tingkat harus dipilih',
        'tingkat.min' => 'Tingkat minimal 1',
        'tingkat.max' => 'Tingkat maksimal 12',
        'kapasitas.required' => 'Kapasitas harus diisi',
        'kapasitas.min' => 'Kapasitas minimal 1',
        'kapasitas.max' => 'Kapasitas maksimal 100',
    ];

    public function mount($id)
    {
        $this->kelasId = $id;
        $kelas = KelasRapor::findOrFail($id);
        
        $this->tahun_ajaran_id = $kelas->tahun_ajaran_id;
        $this->wali_kelas_id = $kelas->wali_kelas_id;
        $this->nama = $kelas->nama;
        $this->tingkat = $this->convertFromRoman($kelas->tingkat);
    }

    public function update()
    {
        $this->validate();

        $kelas = KelasRapor::findOrFail($this->kelasId);
        $kelas->update([
            'tahun_ajaran_id' => $this->tahun_ajaran_id,
            'wali_kelas_id' => $this->wali_kelas_id ?: null,
            'nama' => $this->nama,
            'tingkat' => $this->convertToRoman($this->tingkat),
        ]);

        session()->flash('message', 'Kelas berhasil diperbarui.');
        return redirect()->route('admin.kelas.index');
    }

    private function convertToRoman($number)
    {
        $map = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        return $map[$number] ?? $number;
    }

    private function convertFromRoman($roman)
    {
        $map = [
            'I' => 1, 'II' => 2, 'III' => 3, 'IV' => 4, 'V' => 5, 'VI' => 6,
            'VII' => 7, 'VIII' => 8, 'IX' => 9, 'X' => 10, 'XI' => 11, 'XII' => 12
        ];
        return $map[$roman] ?? $roman;
    }

    public function render()
    {
        $tahunAjarans = TahunAjaran::where('sekolah_id', auth()->user()->sekolah_id)
            ->orderBy('tahun', 'desc')
            ->get();

        $waliKelas = GuruRapor::where('sekolah_id', auth()->user()->sekolah_id)
            ->where('status', 'Aktif')
            ->orderBy('nama')
            ->get();

        return view('livewire.admin.kelas.edit', [
            'tahunAjarans' => $tahunAjarans,
            'waliKelas' => $waliKelas
        ])->layout('layouts.app', ['title' => 'Edit Kelas']);
    }
}
