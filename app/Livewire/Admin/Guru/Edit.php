<?php

namespace App\Livewire\Admin\Guru;

use Livewire\Component;
use App\Models\GuruRapor;
use App\Models\User;

class Edit extends Component
{
    public $guruId;
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
        $guru = GuruRapor::find($this->guruId);
        $userId = $guru?->user_id;

        $rules = [
            'nip' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'nama_arabic' => 'nullable|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'required|email|max:255|unique:users,email,' . $userId,
            'pendidikan_terakhir' => 'nullable|string|max:255',
            'tanggal_mulai_mengajar' => 'nullable|date',
            'status' => 'required|in:Aktif,Tidak Aktif',
            'username' => 'required|string|max:255|unique:users,username,' . $userId,
            'password' => 'nullable|string|min:8',
        ];

        return $rules;
    }

    protected $messages = [
        'nip.required' => 'NIP harus diisi',
        'nama.required' => 'Nama harus diisi',
        'jenis_kelamin.required' => 'Jenis kelamin harus dipilih',
        'status.required' => 'Status harus dipilih',
        'email.required' => 'Email harus diisi',
        'email.unique' => 'Email sudah terdaftar di sistem',
        'username.required' => 'Username harus diisi',
        'username.unique' => 'Username sudah terdaftar',
        'password.min' => 'Password minimal 8 karakter',
    ];

    public function mount($id)
    {
        $this->guruId = $id;
        $guru = GuruRapor::with('user')->findOrFail($id);
        
        $this->nip = $guru->nip;
        $this->nama = $guru->nama;
        $this->nama_arabic = $guru->nama_arabic;
        $this->jenis_kelamin = $guru->jenis_kelamin;
        $this->tempat_lahir = $guru->tempat_lahir;
        $this->tanggal_lahir = $guru->tanggal_lahir ? $guru->tanggal_lahir->format('Y-m-d') : '';
        $this->alamat = $guru->alamat;
        $this->telepon = $guru->telepon;
        $this->email = $guru->email;
        $this->pendidikan_terakhir = $guru->pendidikan_terakhir;
        $this->tanggal_mulai_mengajar = $guru->tanggal_mulai_mengajar ? $guru->tanggal_mulai_mengajar->format('Y-m-d') : '';
        $this->status = $guru->status;
        
        // Load username from user if exists
        if ($guru->user) {
            $this->username = $guru->user->username;
            $this->email = $guru->user->email;
        }
    }

    public function update()
    {
        $this->validate();

        $guru = GuruRapor::findOrFail($this->guruId);
        $guru->update([
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

        // Update or create user account
        if ($guru->user_id) {
            // Update existing user
            $updateData = [
                'name' => $this->nama,
                'username' => $this->username,
                'email' => $this->email,
            ];
            
            // Only update password if provided
            if ($this->password) {
                $updateData['password'] = bcrypt($this->password);
            }
            
            User::where('id', $guru->user_id)->update($updateData);
        } else {
            // Create new user if doesn't exist
            $user = User::create([
                'name' => $this->nama,
                'username' => $this->username,
                'email' => $this->email,
                'password' => bcrypt($this->password ?: 'password'),
                'role' => 'guru',
                'sekolah_id' => auth()->user()->sekolah_id,
            ]);
            
            $guru->update(['user_id' => $user->id]);
        }

        session()->flash('message', 'Guru berhasil diperbarui.');
        $this->redirectRoute('admin.guru.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.guru.edit')->layout('layouts.app', ['title' => 'Edit Guru']);
    }
}
