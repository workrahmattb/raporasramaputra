<?php

namespace App\Livewire\Admin\PenugasanGuru;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TahunAjaran;
use App\Models\Semester;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $tingkat = '';
    public $assignmentToDelete = null;
    public $showDeleteModal = false;

    protected $queryString = ['search', 'tingkat'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingTingkat()
    {
        $this->resetPage();
    }

    public function deleteAssignment()
    {
        if ($this->assignmentToDelete) {
            DB::table('guru_mata_pelajaran')
                ->where('id', $this->assignmentToDelete)
                ->delete();

            $this->showDeleteModal = false;
            $this->assignmentToDelete = null;
            session()->flash('message', 'Penugasan berhasil dihapus.');
        }
    }

    public function confirmDelete($id)
    {
        $this->assignmentToDelete = $id;
        $this->showDeleteModal = true;
    }

    public function render()
    {
        $assignments = DB::table('guru_mata_pelajaran')
            ->join('gurus_rapor', 'guru_mata_pelajaran.guru_id', '=', 'gurus_rapor.id')
            ->join('mata_pelajarans', 'guru_mata_pelajaran.mata_pelajaran_id', '=', 'mata_pelajarans.id')
            ->select(
                'guru_mata_pelajaran.id',
                'gurus_rapor.nama as guru_nama',
                'gurus_rapor.nip',
                'mata_pelajarans.nama as mapel_nama',
                'guru_mata_pelajaran.tingkat'
            )
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('gurus_rapor.nama', 'like', '%' . $this->search . '%')
                      ->orWhere('gurus_rapor.nip', 'like', '%' . $this->search . '%')
                      ->orWhere('mata_pelajarans.nama', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->tingkat, function($query) {
                $query->where('guru_mata_pelajaran.tingkat', $this->tingkat);
            })
            ->orderBy('gurus_rapor.nama')
            ->paginate(15);

        $tahunAjaran = TahunAjaran::where('sekolah_id', auth()->user()->sekolah_id)
            ->where('is_active', true)
            ->first();

        $semester = Semester::where('is_active', true)->first();

        return view('livewire.admin.penugasan-guru.index', [
            'assignments' => $assignments,
            'tahunAjaran' => $tahunAjaran,
            'semester' => $semester
        ])->layout('layouts.app', ['title' => 'Penugasan Guru']);
    }
}
