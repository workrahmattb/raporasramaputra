<?php

namespace App\Livewire\Guru\InputNilai;

use Livewire\Component;
use App\Models\GuruRapor;
use App\Models\KelasRapor;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    public function render()
    {
        $guru = GuruRapor::where('user_id', auth()->id())->first();

        if (!$guru) {
            return view('livewire.guru.input-nilai.index', [
                'assignments' => collect([])
            ])->layout('layouts.app', ['title' => 'Input Nilai']);
        }

        // Get assignments from guru_mata_pelajaran pivot table (now by tingkat)
        $assignments = DB::table('guru_mata_pelajaran')
            ->join('mata_pelajarans', 'guru_mata_pelajaran.mata_pelajaran_id', '=', 'mata_pelajarans.id')
            ->where('guru_mata_pelajaran.guru_id', $guru->id)
            ->select(
                'guru_mata_pelajaran.id as assignment_id',
                'mata_pelajarans.id as mata_pelajaran_id',
                'mata_pelajarans.nama as mata_pelajaran_nama',
                'guru_mata_pelajaran.tingkat'
            )
            ->get();

        // Group assignments by tingkat and mapel, then expand to all classes in that tingkat
        $expandedAssignments = collect([]);
        
        foreach ($assignments as $assignment) {
            // Get all classes in this tingkat with active tahun ajaran
            $kelasList = KelasRapor::where('tingkat', $assignment->tingkat)
                ->whereHas('tahunAjaran', function($q) {
                    $q->where('is_active', true);
                })
                ->orderBy('nama')
                ->get();

            foreach ($kelasList as $kelas) {
                $expandedAssignments->push((object)[
                    'assignment_id' => $assignment->assignment_id,
                    'mata_pelajaran_id' => $assignment->mata_pelajaran_id,
                    'mata_pelajaran_nama' => $assignment->mata_pelajaran_nama,
                    'kelas_id' => $kelas->id,
                    'kelas_nama' => $kelas->nama,
                    'kelas_tingkat' => $kelas->tingkat,
                ]);
            }
        }

        return view('livewire.guru.input-nilai.index', [
            'assignments' => $expandedAssignments
        ])->layout('layouts.app', ['title' => 'Input Nilai']);
    }
}
