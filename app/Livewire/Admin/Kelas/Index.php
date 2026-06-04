<?php

namespace App\Livewire\Admin\Kelas;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\KelasRapor;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $tahun_ajaran_filter = '';
    public $confirmingDeletion = false;
    public $kelasToDelete = null;

    protected $queryString = ['search', 'tahun_ajaran_filter'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingTahunAjaranFilter()
    {
        $this->resetPage();
    }

    public function confirmDelete($id)
    {
        $this->kelasToDelete = $id;
        $this->confirmingDeletion = true;
    }

    public function delete()
    {
        $kelas = KelasRapor::findOrFail($this->kelasToDelete);
        $kelas->delete();
        
        $this->confirmingDeletion = false;
        $this->kelasToDelete = null;
        
        session()->flash('message', 'Kelas berhasil dihapus.');
    }

    public function render()
    {
        $tahunAjarans = \App\Models\TahunAjaran::where('sekolah_id', auth()->user()->sekolah_id)
            ->orderBy('tahun', 'desc')
            ->get();

        $kelas = KelasRapor::with(['tahunAjaran', 'waliKelas'])
            ->whereHas('tahunAjaran', function($q) {
                $q->where('sekolah_id', auth()->user()->sekolah_id);
            })
            ->when($this->search, function($query) {
                $search = '%' . $this->search . '%';
                $query->where(function($q) use ($search) {
                    $q->where('nama', 'like', $search)
                      ->orWhereHas('siswas', function($sq) use ($search) {
                          $sq->where('nama', 'like', $search)
                            ->orWhere('nisn', 'like', $search);
                      });
                });
            })
            ->when($this->tahun_ajaran_filter, function($query) {
                $query->where('tahun_ajaran_id', $this->tahun_ajaran_filter);
            })
            ->orderBy('nama')
            ->paginate(15);

        return view('livewire.admin.kelas.index', [
            'kelas' => $kelas,
            'tahunAjarans' => $tahunAjarans
        ])->layout('layouts.app', ['title' => 'Kelola Kelas']);
    }
}
