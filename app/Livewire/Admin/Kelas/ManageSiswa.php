<?php

namespace App\Livewire\Admin\Kelas;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\KelasRapor;
use App\Models\SiswaRapor;
use Illuminate\Support\Facades\DB;

class ManageSiswa extends Component
{
    use WithPagination;
    
    public $kelasId;
    public $kelas;
    public $siswaId;
    public $confirmingDeletion = false;
    public $siswaToDelete = null;
    // Search properties
    public $searchSiswa = '';
    public $selectedSiswa = null;
    public $showDropdown = false;

    protected $rules = [
        'siswaId' => 'required|exists:siswas_rapor,id',
    ];

    protected $messages = [
        'siswaId.required' => 'Pilih siswa terlebih dahulu',
        'siswaId.exists' => 'Siswa tidak ditemukan',
    ];

    public function mount($kelasId)
    {
        $this->kelasId = $kelasId;
        $this->kelas = KelasRapor::with('tahunAjaran')->findOrFail($kelasId);
    }

    public function updatedSearchSiswa()
    {
        $this->showDropdown = true;
        $this->selectedSiswa = null;
        $this->resetPage('searchSiswaPage');
    }

    public function selectSiswa($siswaId, $siswaNama)
    {
        $this->siswaId = $siswaId;
        $this->selectedSiswa = ['id' => $siswaId, 'nama' => $siswaNama];
        $this->searchSiswa = '';
        $this->showDropdown = false;
    }

    public function addSiswa()
    {
        $this->validate();

        // Check if siswa already in this kelas
        $exists = DB::table('kelas_siswa')
            ->where('kelas_id', $this->kelasId)
            ->where('siswa_id', $this->siswaId)
            ->exists();

        if ($exists) {
            $this->addError('siswaId', 'Siswa sudah ada di kelas ini');
            return;
        }

        // Add siswa to kelas
        DB::table('kelas_siswa')->insert([
            'kelas_id' => $this->kelasId,
            'siswa_id' => $this->siswaId,
            'nomor_absen' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        session()->flash('message', 'Siswa berhasil ditambahkan ke kelas.');

        // Reset form
        $this->reset(['siswaId', 'searchSiswa', 'selectedSiswa']);
    }

    public function confirmDelete($siswaId)
    {
        $this->siswaToDelete = $siswaId;
        $this->confirmingDeletion = true;
    }

    public function deleteSiswa()
    {
        DB::table('kelas_siswa')
            ->where('kelas_id', $this->kelasId)
            ->where('siswa_id', $this->siswaToDelete)
            ->delete();

        $this->confirmingDeletion = false;
        $this->siswaToDelete = null;

        session()->flash('message', 'Siswa berhasil dihapus dari kelas.');
    }

    public function getAvailableSiswasProperty()
    {
        // Get siswa IDs already in any kelas
        $siswaIdsInAnyKelas = DB::table('kelas_siswa')
            ->pluck('siswa_id')
            ->toArray();

        // Get available students with search
        $query = SiswaRapor::where('sekolah_id', auth()->user()->sekolah_id)
            ->whereNotIn('id', $siswaIdsInAnyKelas);

        // Apply search filter
        if ($this->searchSiswa) {
            $query->where(function($q) {
                $q->where('nama', 'like', '%' . $this->searchSiswa . '%')
                  ->orWhere('nisn', 'like', '%' . $this->searchSiswa . '%');
            });
        }

        return $query->orderBy('nama')->paginate(10, pageName: 'searchSiswaPage');
    }

    public function render()
    {
        // Get students already in this class - sorted alphabetically with pagination
        $siswasDiKelas = DB::table('kelas_siswa')
            ->join('siswas_rapor', 'kelas_siswa.siswa_id', '=', 'siswas_rapor.id')
            ->where('kelas_siswa.kelas_id', $this->kelasId)
            ->select('siswas_rapor.*')
            ->orderBy('siswas_rapor.nama')
            ->paginate(10);

        return view('livewire.admin.kelas.manage-siswa', [
            'siswasDiKelas' => $siswasDiKelas,
        ])->layout('layouts.app', ['title' => 'Kelola Siswa - ' . $this->kelas->nama]);
    }
}
