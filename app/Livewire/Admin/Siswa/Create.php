<?php

namespace App\Livewire\Admin\Siswa;

use Livewire\Component;
use App\Models\SiswaRapor;

class Create extends Component
{
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
        'nisn' => 'required|string|max:255|unique:siswas_rapor,nisn',
        'nis' => 'nullable|string|max:255|unique:siswas_rapor,nis',
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

    protected $messages = [
        'nisn.required' => 'NISN harus diisi',
        'nisn.unique' => 'NISN sudah terdaftar',
        'nama.required' => 'Nama harus diisi',
        'jenis_kelamin.required' => 'Jenis kelamin harus dipilih',
        'status.required' => 'Status harus dipilih',
    ];

    public function save()
    {
        $this->validate();

        SiswaRapor::create([
            'sekolah_id' => auth()->user()->sekolah_id,
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

        session()->flash('message', 'Siswa berhasil ditambahkan.');
        return redirect()->route('admin.siswa.index');
    }

    public function render()
    {
        return view('livewire.admin.siswa.create')->layout('layouts.app', ['title' => 'Tambah Siswa']);
    }
}
