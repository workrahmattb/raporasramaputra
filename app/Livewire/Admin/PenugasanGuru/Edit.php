<?php

namespace App\Livewire\Admin\PenugasanGuru;

use Livewire\Component;
use App\Models\GuruRapor;
use App\Models\MataPelajaran;
use App\Models\TahunAjaran;
use App\Models\Semester;
use Illuminate\Support\Facades\DB;

class Edit extends Component
{
    public $assignmentId;
    public $guru_id = '';
    public $mata_pelajaran_id = '';
    public $tingkat = '';

    protected $rules = [
        'guru_id'          => 'required|exists:gurus_rapor,id',
        'mata_pelajaran_id'=> 'required|exists:mata_pelajarans,id',
        'tingkat'          => 'required|in:VII,VIII,IX,X,XI,XII',
    ];

    protected $messages = [
        'guru_id.required'           => 'Guru harus dipilih',
        'mata_pelajaran_id.required' => 'Mata pelajaran harus dipilih',
        'tingkat.required'           => 'Tingkat harus dipilih',
        'tingkat.in'                 => 'Pilih tingkat yang valid (VII, VIII, IX, X, XI, atau XII)',
    ];

    public function mount($id)
    {
        $assignment = DB::table('guru_mata_pelajaran')->where('id', $id)->first();

        if (! $assignment) {
            abort(404);
        }

        $this->assignmentId        = $id;
        $this->guru_id             = $assignment->guru_id;
        $this->mata_pelajaran_id   = $assignment->mata_pelajaran_id;
        $this->tingkat             = $assignment->tingkat;
    }

    public function save()
    {
        $this->validate();

        // Cek apakah kombinasi yang sama sudah ada (selain record ini sendiri)
        $exists = DB::table('guru_mata_pelajaran')
            ->where('guru_id', $this->guru_id)
            ->where('mata_pelajaran_id', $this->mata_pelajaran_id)
            ->where('tingkat', $this->tingkat)
            ->where('id', '!=', $this->assignmentId)
            ->exists();

        if ($exists) {
            session()->flash('error', 'Penugasan dengan kombinasi yang sama sudah ada!');
            return;
        }

        DB::table('guru_mata_pelajaran')
            ->where('id', $this->assignmentId)
            ->update([
                'guru_id'          => $this->guru_id,
                'mata_pelajaran_id'=> $this->mata_pelajaran_id,
                'tingkat'          => $this->tingkat,
                'updated_at'       => now(),
            ]);

        session()->flash('message', 'Penugasan guru berhasil diperbarui.');
        return redirect()->route('admin.penugasan-guru.index');
    }

    public function render()
    {
        $gurus = GuruRapor::where('sekolah_id', auth()->user()->sekolah_id)
            ->where('status', 'Aktif')
            ->orderBy('nama')
            ->get();

        $mataPelajarans = MataPelajaran::where('sekolah_id', auth()->user()->sekolah_id)
            ->orderBy('nama')
            ->get();

        $tingkats = ['VII' => 'VII', 'VIII' => 'VIII', 'IX' => 'IX', 'X' => 'X', 'XI' => 'XI', 'XII' => 'XII'];

        $tahunAjaran = TahunAjaran::where('sekolah_id', auth()->user()->sekolah_id)
            ->where('is_active', true)
            ->first();

        $semester = Semester::where('is_active', true)->first();

        return view('livewire.admin.penugasan-guru.edit', [
            'gurus'          => $gurus,
            'mataPelajarans' => $mataPelajarans,
            'tingkats'       => $tingkats,
            'tahunAjaran'    => $tahunAjaran,
            'semester'       => $semester,
        ])->layout('layouts.app', ['title' => 'Edit Penugasan Guru']);
    }
}
