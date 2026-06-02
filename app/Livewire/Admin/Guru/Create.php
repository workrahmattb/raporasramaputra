<?php

namespace App\Livewire\Admin\Guru;

use Livewire\Component;
use App\Models\GuruRapor;
use App\Models\User;

class Create extends Component
{
    public $nip = '';
    public $nama = '';
    public $nama_arabic = '';
    public $jenis_kelamin = '';
    public $tempat_lahir = '';
    public $tanggal_lahir = '';
    public $alamat = '';
    public $telepon = '';
    public $email = '';
    public $pendidikan_terakhir = '';
    public $tanggal_mulai_mengajar = '';
    public $status = 'Aktif';
    public $username = '';
    public $password = '';

    protected function rules()
    {
        return [
            'nip' => 'required|string|max:255|unique:gurus_rapor,nip',
            'nama' => 'required|string|max:255',
            'nama_arabic' => 'nullable|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'required|email|max:255|unique:users,email',
            'pendidikan_terakhir' => 'nullable|string|max:255',
            'tanggal_mulai_mengajar' => 'nullable|date',
            'status' => 'required|in:Aktif,Tidak Aktif',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:8',
        ];
    }

    protected $messages = [
        'nip.required' => 'NIP harus diisi',
        'nip.unique' => 'NIP sudah terdaftar',
        'nama.required' => 'Nama harus diisi',
        'jenis_kelamin.required' => 'Jenis kelamin harus dipilih',
        'status.required' => 'Status harus dipilih',
        'email.required' => 'Email harus diisi',
        'email.unique' => 'Email sudah terdaftar di sistem',
        'username.required' => 'Username harus diisi',
        'username.unique' => 'Username sudah terdaftar',
        'password.required' => 'Password harus diisi',
        'password.min' => 'Password minimal 8 karakter',
    ];

    public function save()
    {
        $this->validate();

        // Always create user account for guru
        $user = User::create([
            'name' => $this->nama,
            'username' => $this->username,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'role' => 'guru',
            'sekolah_id' => auth()->user()->sekolah_id,
        ]);

        GuruRapor::create([
            'sekolah_id' => auth()->user()->sekolah_id,
            'user_id' => $user->id,
            'nip' => $this->nip,
            'nama' => $this->nama,
            'nama_arabic' => $this->nama_arabic,
            'jenis_kelamin' => $this->jenis_kelamin,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir ?: null,
            'alamat' => $this->alamat,
            'telepon' => $this->telepon,
            'email' => $this->email,
            'pendidikan_terakhir' => $this->pendidikan_terakhir,
            'tanggal_mulai_mengajar' => $this->tanggal_mulai_mengajar ?: null,
            'status' => $this->status,
        ]);

        session()->flash('message', 'Guru berhasil ditambahkan.');
        $this->redirectRoute('admin.guru.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.guru.create')->layout('layouts.app', ['title' => 'Tambah Guru']);
    }
}
