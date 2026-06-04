<?php

namespace App\Livewire\Admin\MataPelajaran;

use Livewire\Component;
use App\Models\MataPelajaran;

class Create extends Component
{
    public $kode = '';
    public $nama = '';
    public $namapelajaran_arabic = '';
    public $kkm = 75;

    protected $rules = [
        'kode' => 'required|string|max:10',
        'nama' => 'required|string|max:255',
        'namapelajaran_arabic' => 'nullable|string|max:255',
        'kkm' => 'required|integer|min:0|max:100',
    ];

    protected $messages = [
        'kode.required' => 'Kode mata pelajaran harus diisi',
        'nama.required' => 'Nama mata pelajaran harus diisi',
        'kkm.required' => 'KKM harus diisi',
        'kkm.min' => 'KKM minimal 0',
        'kkm.max' => 'KKM maksimal 100',
    ];

    public function save()
    {
        // Cek duplikasi kode manual via Eloquent
        $existing = MataPelajaran::where('kode', $this->kode)
            ->where('sekolah_id', auth()->user()->sekolah_id)
            ->first();

        if ($existing) {
            $this->addError('kode', 'Kode mata pelajaran sudah digunakan, tidak bisa menyimpan kode yang sama');
            return;
        }

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
