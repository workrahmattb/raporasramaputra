<?php

namespace App\Livewire\Admin\Siswa;

use Livewire\Component;
use App\Models\SiswaRapor;

class View extends Component
{
    public $siswa;

    public function mount($id)
    {
        $this->siswa = SiswaRapor::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.admin.siswa.view')
            ->layout('layouts.app', ['title' => 'Detail Siswa']);
    }
}
