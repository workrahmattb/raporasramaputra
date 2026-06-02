<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'npsn',
        'alamat',
        'telepon',
        'email',
        'kepala_sekolah',
        'nip_kepala_sekolah',
        'logo',
    ];

    // Relationships
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function tahunAjarans()
    {
        return $this->hasMany(TahunAjaran::class);
    }

    public function siswas()
    {
        return $this->hasMany(SiswaRapor::class);
    }

    public function gurus()
    {
        return $this->hasMany(GuruRapor::class);
    }

    public function mataPelajarans()
    {
        return $this->hasMany(MataPelajaran::class);
    }
}
