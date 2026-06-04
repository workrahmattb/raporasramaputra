<?php

namespace App\Livewire\Admin\Kelas;

use Livewire\Component;
use App\Models\KelasRapor;
use App\Models\TahunAjaran;
use App\Models\GuruRapor;

class Create extends Component
{
    public $tahun_ajaran_id = '';
    public $wali_kelas_id = '';
    public $nama = '';

    protected $rules = [
        'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
        'wali_kelas_id' => 'nullable|exists:gurus_rapor,id',
        'nama' => 'required|string|max:255',
    ];

    protected $messages = [
        'tahun_ajaran_id.required' => 'Tahun ajaran harus dipilih',
        'nama.required' => 'Nama kelas harus diisi',
    ];

    public function save()
    {
        $this->validate();

        KelasRapor::create([
            'sekolah_id' => auth()->user()->sekolah_id,
            'tahun_ajaran_id' => $this->tahun_ajaran_id,
            'wali_kelas_id' => $this->wali_kelas_id ?: null,
            'nama' => $this->nama,
        ]);

        session()->flash('message', 'Kelas berhasil ditambahkan.');
        return redirect()->route('admin.kelas.index');
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

        return view('livewire.admin.kelas.create', [
            'tahunAjarans' => $tahunAjarans,
            'waliKelas' => $waliKelas
        ])->layout('layouts.app', ['title' => 'Tambah Kelas']);
    }
}
