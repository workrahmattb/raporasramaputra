<?php

namespace App\Livewire\Admin\RaporSettings;

use Livewire\Component;
use App\Models\RaporSetting;

class Edit extends Component
{
    public $tanggal_rapor = '';
    public $kepala_sekolah_mts = '';
    public $kepala_sekolah_ma = '';

    protected $rules = [
        'tanggal_rapor' => 'required|string|max:255',
        'kepala_sekolah_mts' => 'required|string|max:255',
        'kepala_sekolah_ma' => 'required|string|max:255',
    ];

    protected $messages = [
        'tanggal_rapor.required' => 'Tanggal rapor harus diisi',
        'kepala_sekolah_mts.required' => 'Nama Kepala Sekolah MTs harus diisi',
        'kepala_sekolah_ma.required' => 'Nama Kepala Sekolah MA harus diisi',
    ];

    public function mount()
    {
        $settings = RaporSetting::getSettings();
        
        $this->tanggal_rapor = $settings->tanggal_rapor;
        $this->kepala_sekolah_mts = $settings->kepala_sekolah_mts;
        $this->kepala_sekolah_ma = $settings->kepala_sekolah_ma;
    }

    public function save()
    {
        $this->validate();

        $settings = RaporSetting::getSettings();
        $settings->update([
            'tanggal_rapor' => $this->tanggal_rapor,
            'kepala_sekolah_mts' => $this->kepala_sekolah_mts,
            'kepala_sekolah_ma' => $this->kepala_sekolah_ma,
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
