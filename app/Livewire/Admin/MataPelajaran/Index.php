<?php

namespace App\Livewire\Admin\MataPelajaran;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\MataPelajaran;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $confirmingDeletion = false;
    public $mataPelajaranToDelete = null;

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDelete($id)
    {
        $this->mataPelajaranToDelete = $id;
        $this->confirmingDeletion = true;
    }

    public function delete()
    {
        $mataPelajaran = MataPelajaran::findOrFail($this->mataPelajaranToDelete);
        $mataPelajaran->delete();
        
        $this->confirmingDeletion = false;
        $this->mataPelajaranToDelete = null;
        
        session()->flash('message', 'Mata pelajaran berhasil dihapus.');
    }

    public function render()
    {
        $mataPelajarans = MataPelajaran::where('sekolah_id', auth()->user()->sekolah_id)
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('nama', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('nama')
            ->paginate(15);

        return view('livewire.admin.mata-pelajaran.index', [
            'mataPelajarans' => $mataPelajarans
        ])->layout('layouts.app', ['title' => 'Kelola Mata Pelajaran']);
    }
}
