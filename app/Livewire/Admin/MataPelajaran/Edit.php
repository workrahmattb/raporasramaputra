<?php

namespace App\Livewire\Admin\MataPelajaran;

use Livewire\Component;
use App\Models\MataPelajaran;

class Edit extends Component
{
    public $mataPelajaranId;
    public $nama = '';
    public $deskripsi = '';
    public $kkm = 75;

    protected $rules = [
        'nama' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        'kkm' => 'required|integer|min:0|max:100',
    ];

    protected $messages = [
        'nama.required' => 'Nama mata pelajaran harus diisi',
        'kkm.required' => 'KKM harus diisi',
        'kkm.min' => 'KKM minimal 0',
        'kkm.max' => 'KKM maksimal 100',
    ];

    public function mount($id)
    {
        $this->mataPelajaranId = $id;
        $mataPelajaran = MataPelajaran::findOrFail($id);
        
        $this->nama = $mataPelajaran->nama;
        $this->deskripsi = $mataPelajaran->deskripsi ?? '';
        $this->kkm = $mataPelajaran->kkm;
    }

    public function update()
    {
        $this->validate();

        $mataPelajaran = MataPelajaran::findOrFail($this->mataPelajaranId);
        $mataPelajaran->update([
            'nama' => $this->nama,
            'deskripsi' => $this->deskripsi,
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
