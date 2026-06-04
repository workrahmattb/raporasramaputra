<?php

namespace App\Livewire\Guru\InputNilai;

use Livewire\Component;
use App\Models\GuruRapor;
use App\Models\KelasRapor;

class Index extends Component
{
    public function render()
    {
        $guru = GuruRapor::where('user_id', auth()->id())->first();

        if (!$guru) {
            return view('livewire.guru.input-nilai.index', [
                'kelasList' => collect([])
            ])->layout('layouts.app', ['title' => 'Input Nilai']);
        }

        // Get all asrama where this guru is wali_kelas
        $kelasList = KelasRapor::where('wali_kelas_id', $guru->id)
            ->whereHas('tahunAjaran', function($q) {
                $q->where('is_active', true);
            })
            ->orderBy('nama')
            ->get();

        // Pass kelas list directly — mapel selection happens in the form
        return view('livewire.guru.input-nilai.index', [
            'kelasList' => $kelasList
        ])->layout('layouts.app', ['title' => 'Input Nilai']);
    }
}
