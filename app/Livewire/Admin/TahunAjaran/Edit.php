<?php

namespace App\Livewire\Admin\TahunAjaran;

use Livewire\Component;
use App\Models\TahunAjaran;

class Edit extends Component
{
    public $tahunAjaranId;
    public $tahun = '';
    public $tanggal_mulai = '';
    public $tanggal_selesai = '';

    protected $rules = [
        'tahun' => 'required|string|max:255',
        'tanggal_mulai' => 'required|date',
        'tanggal_selesai' => 'required|date|after:tanggal_mulai',
    ];

    protected $messages = [
        'tahun.required' => 'Tahun ajaran harus diisi',
        'tanggal_mulai.required' => 'Tanggal mulai harus diisi',
        'tanggal_selesai.required' => 'Tanggal selesai harus diisi',
        'tanggal_selesai.after' => 'Tanggal selesai harus setelah tanggal mulai',
    ];

    public function mount($id)
    {
        $this->tahunAjaranId = $id;
        $tahunAjaran = TahunAjaran::findOrFail($id);
        
        $this->tahun = $tahunAjaran->tahun;
        $this->tanggal_mulai = $tahunAjaran->tanggal_mulai->format('Y-m-d');
        $this->tanggal_selesai = $tahunAjaran->tanggal_selesai->format('Y-m-d');
    }

    public function update()
    {
        $this->validate();

        $tahunAjaran = TahunAjaran::findOrFail($this->tahunAjaranId);
        $tahunAjaran->update([
            'tahun' => $this->tahun,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_selesai' => $this->tanggal_selesai,
        ]);

        session()->flash('message', 'Tahun ajaran berhasil diperbarui.');
        $this->redirectRoute('admin.tahun-ajaran.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.tahun-ajaran.edit')
            ->layout('layouts.app', ['title' => 'Edit Tahun Ajaran']);
    }
}
