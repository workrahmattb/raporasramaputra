<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TahunAjaran;
use App\Models\Semester;

class SelectAcademicPeriod extends Component
{
    public $tahun_ajaran_id = '';
    public $semester_id = '';
    public $tahunAjarans = [];
    public $semesters = [];

    protected $rules = [
        'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
        'semester_id' => 'required|exists:semesters,id',
    ];

    public function mount()
    {
        // Load tahun ajaran for user's school
        $this->tahunAjarans = TahunAjaran::where('sekolah_id', auth()->user()->sekolah_id)
            ->orderBy('tahun', 'desc')
            ->get();

        // Pre-select active tahun ajaran if exists
        $activeTahunAjaran = TahunAjaran::where('sekolah_id', auth()->user()->sekolah_id)
            ->where('is_active', true)
            ->first();

        if ($activeTahunAjaran) {
            $this->tahun_ajaran_id = $activeTahunAjaran->id;
            $this->loadSemesters();

            // Pre-select active semester if exists
            $activeSemester = Semester::where('is_active', true)->first();
            if ($activeSemester && $activeSemester->tahun_ajaran_id == $this->tahun_ajaran_id) {
                $this->semester_id = $activeSemester->id;
            }
        }
    }

    public function updatedTahunAjaranId()
    {
        $this->semester_id = '';
        $this->loadSemesters();
    }

    public function loadSemesters()
    {
        if ($this->tahun_ajaran_id) {
            $this->semesters = Semester::where('tahun_ajaran_id', $this->tahun_ajaran_id)
                ->orderBy('nama')
                ->get();
        } else {
            $this->semesters = [];
        }
    }

    public function save()
    {
        $this->validate();

        // Save selection to user's session fields
        auth()->user()->setSessionAcademicPeriod($this->tahun_ajaran_id, $this->semester_id);

        session()->flash('message', 'Periode akademik berhasil dipilih.');

        // Redirect to dashboard
        $this->redirectRoute('dashboard', navigate: true);
    }

    public function render()
    {
        return view('livewire.select-academic-period')
            ->layout('layouts.guest');
    }
}
