<?php

namespace App\Livewire\Admin\MataPelajaran;

use Livewire\Component;
use App\Models\MataPelajaran;

class Edit extends Component
{
    public $mataPelajaranId;
    public $kode = '';
    public $nama = '';
    public $namapelajaran_arabic = '';
    public $kelompok = 'A';
    public $tingkat = '';
    public $kkm = 75;

    protected $rules = [
        'kode' => 'required|string|max:10',
        'nama' => 'required|string|max:255',
        'namapelajaran_arabic' => 'nullable|string|max:255',
        'kelompok' => 'required|in:A,B,C',
        'tingkat' => 'nullable|in:7,8,9,10,11,12',
        'kkm' => 'required|integer|min:0|max:100',
    ];

    protected $messages = [
        'kode.required' => 'Kode mata pelajaran harus diisi',
        'nama.required' => 'Nama mata pelajaran harus diisi',
        'kelompok.required' => 'Kelompok harus dipilih',
        'kkm.required' => 'KKM harus diisi',
        'kkm.min' => 'KKM minimal 0',
        'kkm.max' => 'KKM maksimal 100',
    ];

    public function mount($id)
    {
        $this->mataPelajaranId = $id;
        $mataPelajaran = MataPelajaran::findOrFail($id);
        
        $this->kode = $mataPelajaran->kode;
        $this->nama = $mataPelajaran->nama;
        $this->namapelajaran_arabic = $mataPelajaran->namapelajaran_arabic;
        $this->kelompok = $mataPelajaran->kelompok;
        $this->tingkat = $mataPelajaran->tingkat;
        $this->kkm = $mataPelajaran->kkm;
    }

    public function update()
    {
        $this->validate();

        $mataPelajaran = MataPelajaran::findOrFail($this->mataPelajaranId);
        $mataPelajaran->update([
            'kode' => $this->kode,
            'nama' => $this->nama,
            'namapelajaran_arabic' => $this->namapelajaran_arabic,
            'kelompok' => $this->kelompok,
            'tingkat' => $this->tingkat,
            'kkm' => $this->kkm,
        ]);

        session()->flash('message', 'Mata pelajaran berhasil diperbarui.');
        $this->redirectRoute('admin.mata-pelajaran.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.mata-pelajaran.edit')
            ->layout('layouts.app', ['title' => 'Edit Mata Pelajaran']);
    }
}
