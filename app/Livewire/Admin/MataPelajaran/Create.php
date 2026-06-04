<?php

namespace App\Livewire\Admin\MataPelajaran;

use Livewire\Component;
use App\Models\MataPelajaran;

class Create extends Component
{
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

    public function save()
    {
        $validated = $this->validate();

        MataPelajaran::create(array_merge($validated, [
            'sekolah_id' => auth()->user()->sekolah_id,
        ]));

        session()->flash('message', 'Mata pelajaran berhasil ditambahkan.');
        $this->redirectRoute('admin.mata-pelajaran.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.mata-pelajaran.create')
            ->layout('layouts.app', ['title' => 'Tambah Mata Pelajaran']);
    }
}
