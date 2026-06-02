<?php

namespace App\Livewire\Admin\Guru;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\GuruRapor;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $status_filter = '';
    public $confirmingDeletion = false;
    public $guruToDelete = null;

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
        $this->guruToDelete = $id;
        $this->confirmingDeletion = true;
    }

    public function delete()
    {
        if ($this->guruToDelete) {
            GuruRapor::findOrFail($this->guruToDelete)->delete();
            session()->flash('message', 'Guru berhasil dihapus.');
            $this->confirmingDeletion = false;
            $this->guruToDelete = null;
        }
    }

    public function render()
    {
        $gurus = GuruRapor::where('sekolah_id', auth()->user()->sekolah_id)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nama', 'like', '%' . $this->search . '%')
                      ->orWhere('nip', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status_filter, function ($query) {
                $query->where('status', $this->status_filter);
            })
            ->orderBy('nama')
            ->paginate(10);

        return view('livewire.admin.guru.index', [
            'gurus' => $gurus
        ])->layout('layouts.app', ['title' => 'Kelola Guru']);
    }
}
