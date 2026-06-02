<?php

namespace App\Livewire\Admin\TahunAjaran;

use Livewire\Component;
use App\Models\TahunAjaran;
use App\Models\Semester;

class Create extends Component
{
    public $tahun = '';
    public $tanggal_mulai = '';
    public $tanggal_selesai = '';
    public $create_semesters = true;

    protected $rules = [
        'tahun' => 'required|string|max:255',
        'tanggal_mulai' => 'required|date',
        'tanggal_selesai' => 'required|date|after:tanggal_mulai',
    ];

    protected $messages = [
        'tahun.required' => 'Tahun ajaran harus diisi',
        'tanggal_mulai.required' => 'Tanggal mulai harus diisi',
        'tanggal_selesai.required' => 'Tanggal selesai harus diisi',
        'tanggal_selesai.after' => 'Tanggal selesai harus setelah tanggal mulai',
    ];

    public function save()
    {
        $this->validate();

        $tahunAjaran = TahunAjaran::create([
            'sekolah_id' => auth()->user()->sekolah_id,
            'tahun' => $this->tahun,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_selesai' => $this->tanggal_selesai,
            'is_active' => false,
        ]);

        // Auto create semesters
        if ($this->create_semesters) {
            $tanggalMulai = \Carbon\Carbon::parse($this->tanggal_mulai);
            $tanggalSelesai = \Carbon\Carbon::parse($this->tanggal_selesai);
            $tengah = $tanggalMulai->copy()->addMonths(6);

            Semester::create([
                'tahun_ajaran_id' => $tahunAjaran->id,
                'nama' => 'Ganjil',
                'tanggal_mulai' => $tanggalMulai,
                'tanggal_selesai' => $tengah,
                'is_active' => false,
            ]);

            Semester::create([
                'tahun_ajaran_id' => $tahunAjaran->id,
                'nama' => 'Genap',
                'tanggal_mulai' => $tengah->copy()->addDay(),
                'tanggal_selesai' => $tanggalSelesai,
                'is_active' => false,
            ]);
        }

        session()->flash('message', 'Tahun ajaran berhasil ditambahkan.');
        return redirect()->route('admin.tahun-ajaran.index');
    }

    public function render()
    {
        return view('livewire.admin.tahun-ajaran.create')
            ->layout('layouts.app', ['title' => 'Tambah Tahun Ajaran']);
    }
}
