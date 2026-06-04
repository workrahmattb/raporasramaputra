<?php

namespace App\Livewire\Admin\Siswa;

use Livewire\Component;
use App\Models\SiswaRapor;

class Edit extends Component
{
    public $siswaId;
    public $nisn = '';
    public $nis = '';
    public $nama = '';
    public $jenis_kelamin = '';
    public $tempat_lahir = '';
    public $tanggal_lahir = '';
    public $alamat = '';
    public $telepon = '';
    public $email = '';
    public $nama_ayah = '';
    public $nama_ibu = '';
    public $telepon_ortu = '';
    public $tanggal_masuk = '';
    public $status = 'Aktif';

    protected $rules = [
        'nisn' => 'required|string|max:255',
        'nis' => 'nullable|string|max:255',
        'nama' => 'required|string|max:255',
        'jenis_kelamin' => 'required|in:L,P',
        'tempat_lahir' => 'nullable|string|max:255',
        'tanggal_lahir' => 'nullable|date',
        'alamat' => 'nullable|string',
        'telepon' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:255',
        'nama_ayah' => 'nullable|string|max:255',
        'nama_ibu' => 'nullable|string|max:255',
        'telepon_ortu' => 'nullable|string|max:20',
        'tanggal_masuk' => 'nullable|date',
        'status' => 'required|in:Aktif,Tidak Aktif,Lulus,Pindah',
    ];

    public function rules()
    {
        return [
            'nisn' => 'required|string|max:255|unique:siswas_rapor,nisn,' . $this->siswaId,
            'nis' => 'nullable|string|max:255|unique:siswas_rapor,nis,' . $this->siswaId,
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'telepon_ortu' => 'nullable|string|max:20',
            'tanggal_masuk' => 'nullable|date',
            'status' => 'required|in:Aktif,Tidak Aktif,Lulus,Pindah',
        ];
    }

    protected $messages = [
        'nisn.required' => 'NISN harus diisi',
        'nama.required' => 'Nama harus diisi',
        'jenis_kelamin.required' => 'Jenis kelamin harus dipilih',
        'status.required' => 'Status harus dipilih',
    ];

    public function mount($id)
    {
        $this->siswaId = $id;
        $siswa = SiswaRapor::findOrFail($id);
        
        $this->nisn = $siswa->nisn;
        $this->nis = $siswa->nis;
        $this->nama = $siswa->nama;
        $this->jenis_kelamin = $siswa->jenis_kelamin;
        $this->tempat_lahir = $siswa->tempat_lahir;
        $this->tanggal_lahir = $siswa->tanggal_lahir ? $siswa->tanggal_lahir->format('Y-m-d') : '';
        $this->alamat = $siswa->alamat;
        $this->telepon = $siswa->telepon;
        $this->email = $siswa->email;
        $this->nama_ayah = $siswa->nama_ayah;
        $this->nama_ibu = $siswa->nama_ibu;
        $this->telepon_ortu = $siswa->telepon_ortu;
        $this->tanggal_masuk = $siswa->tanggal_masuk ? $siswa->tanggal_masuk->format('Y-m-d') : '';
        $this->status = $siswa->status;
    }

    public function update()
    {
        $this->validate();

        $siswa = SiswaRapor::findOrFail($this->siswaId);
        $siswa->update([
            'nisn' => $this->nisn,
            'nis' => $this->nis ?: null, // Convert empty string to null
            'nama' => $this->nama,
            'jenis_kelamin' => $this->jenis_kelamin,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir ?: null,
            'alamat' => $this->alamat,
            'telepon' => $this->telepon,
            'email' => $this->email,
            'nama_ayah' => $this->nama_ayah,
            'nama_ibu' => $this->nama_ibu,
            'telepon_ortu' => $this->telepon_ortu,
            'tanggal_masuk' => $this->tanggal_masuk ?: null,
            'status' => $this->status,
        ]);

        session()->flash('message', 'Siswa berhasil diperbarui.');
        $this->redirectRoute('admin.siswa.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.siswa.edit')->layout('layouts.app', ['title' => 'Edit Siswa']);
    }
}
