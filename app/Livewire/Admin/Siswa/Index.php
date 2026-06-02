<?php

namespace App\Livewire\Admin\Siswa;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SiswaRapor;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $status_filter = '';
    public $confirmingDeletion = false;
    public $siswaToDelete = null;

    protected $queryString = ['search', 'status_filter'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function confirmDelete($id)
    {
        $this->siswaToDelete = $id;
        $this->confirmingDeletion = true;
    }

    public function delete()
    {
        if ($this->siswaToDelete) {
            SiswaRapor::findOrFail($this->siswaToDelete)->forceDelete();
            session()->flash('message', 'Siswa berhasil dihapus permanen.');
            $this->confirmingDeletion = false;
            $this->siswaToDelete = null;
        }
    }

    public function render()
    {
        $siswas = SiswaRapor::where('sekolah_id', auth()->user()->sekolah_id)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nama', 'like', '%' . $this->search . '%')
                      ->orWhere('nisn', 'like', '%' . $this->search . '%')
                      ->orWhere('nis', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status_filter, function ($query) {
                $query->where('status', $this->status_filter);
            })
            ->orderBy('nama')
            ->paginate(10);

        return view('livewire.admin.siswa.index', [
            'siswas' => $siswas
        ])->layout('layouts.app', ['title' => 'Kelola Siswa']);
    }
}
