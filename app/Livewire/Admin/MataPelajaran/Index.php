<?php

namespace App\Livewire\Admin\MataPelajaran;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\MataPelajaran;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $kelompok = '';
    public $tingkat = '';
    public $confirmingDeletion = false;
    public $mataPelajaranToDelete = null;

    // Inline editing for Arabic names
    public $editingNamaArabic = [];
    public $namaArabicValues = [];

    protected $queryString = ['search', 'kelompok', 'tingkat'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingKelompok()
    {
        $this->resetPage();
    }

    public function updatingTingkat()
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

    public function editNamaArabic($mataPelajaranId)
    {
        $this->editingNamaArabic[$mataPelajaranId] = true;
        $mataPelajaran = MataPelajaran::find($mataPelajaranId);
        $this->namaArabicValues[$mataPelajaranId] = $mataPelajaran->namapelajaran_arabic ?? '';
    }

    public function cancelEditNamaArabic($mataPelajaranId)
    {
        $this->editingNamaArabic[$mataPelajaranId] = false;
        unset($this->namaArabicValues[$mataPelajaranId]);
    }

    public function updateNamaArabic($mataPelajaranId)
    {
        $mataPelajaran = MataPelajaran::findOrFail($mataPelajaranId);
        $mataPelajaran->update([
            'namapelajaran_arabic' => $this->namaArabicValues[$mataPelajaranId] ?? null
        ]);

        $this->editingNamaArabic[$mataPelajaranId] = false;
        session()->flash('message', 'Nama Arabic berhasil diperbarui.');
    }

    public function render()
    {
        $mataPelajarans = MataPelajaran::where('sekolah_id', auth()->user()->sekolah_id)
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('nama', 'like', '%' . $this->search . '%')
                      ->orWhere('kode', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->kelompok, function($query) {
                $query->where('kelompok', $this->kelompok);
            })
            ->when($this->tingkat, function($query) {
                $query->where('tingkat', $this->tingkat);
            })
            ->orderBy('kelompok')
            ->orderBy('nama')
            ->paginate(15);

        return view('livewire.admin.mata-pelajaran.index', [
            'mataPelajarans' => $mataPelajarans
        ])->layout('layouts.app', ['title' => 'Kelola Mata Pelajaran']);
    }
}
