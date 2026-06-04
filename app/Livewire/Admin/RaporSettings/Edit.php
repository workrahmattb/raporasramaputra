<?php

namespace App\Livewire\Admin\RaporSettings;

use Livewire\Component;
use App\Models\RaporSetting;

class Edit extends Component
{
    public $tanggal_rapor = '';
    public $kepala_pengasuhan_asrama = '';
    public $pimpinan_pondok = '';

    protected $rules = [
        'tanggal_rapor' => 'required|string|max:255',
        'kepala_pengasuhan_asrama' => 'required|string|max:255',
        'pimpinan_pondok' => 'required|string|max:255',
    ];

    protected $messages = [
        'tanggal_rapor.required' => 'Tanggal rapor harus diisi',
        'kepala_pengasuhan_asrama.required' => 'Nama Kepala Pengasuhan Asrama harus diisi',
        'pimpinan_pondok.required' => 'Nama Pimpinan Pondok Pesantren harus diisi',
    ];

    public function mount()
    {
        $settings = RaporSetting::getSettings();
        
        $this->tanggal_rapor = $settings->tanggal_rapor;
        $this->kepala_pengasuhan_asrama = $settings->kepala_pengasuhan_asrama;
        $this->pimpinan_pondok = $settings->pimpinan_pondok;
    }

    public function save()
    {
        $this->validate();

        $settings = RaporSetting::getSettings();
        $settings->update([
            'tanggal_rapor' => $this->tanggal_rapor,
            'kepala_pengasuhan_asrama' => $this->kepala_pengasuhan_asrama,
            'pimpinan_pondok' => $this->pimpinan_pondok,
        ]);

        session()->flash('message', 'Pengaturan rapor berhasil disimpan.');
        session()->flash('message_type', 'success');
    }

    public function render()
    {
        return view('livewire.admin.rapor-settings.edit')
            ->layout('layouts.app', ['title' => 'Pengaturan Rapor']);
    }
}
