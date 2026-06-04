<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiswaRapor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'siswas_rapor';

    protected $fillable = [
        'sekolah_id',
        'nisn',
        'nis',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'telepon',
        'email',
        'nama_ayah',
        'nama_ibu',
        'telepon_ortu',
        'tanggal_masuk',
        'status',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_masuk' => 'date',
    ];

    // Relationships
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function kelas()
    {
        return $this->belongsToMany(KelasRapor::class, 'kelas_siswa', 'siswa_id', 'kelas_id')
                    ->withPivot('nomor_absen')
                    ->withTimestamps();
    }

    public function nilais()
    {
        return $this->hasMany(Nilai::class, 'siswa_id');
    }

    public function nilaiSikaps()
    {
        return $this->hasMany(NilaiSikap::class, 'siswa_id');
    }

    public function kehadirans()
    {
        return $this->hasMany(Kehadiran::class, 'siswa_id');
    }

    public function catatanWaliKelas()
    {
        return $this->hasMany(CatatanWaliKelas::class, 'siswa_id');
    }

    public function kenaikanKelas()
    {
        return $this->hasMany(KenaikanKelas::class, 'siswa_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'Aktif');
    }

    // Accessors
    public function getNamaLengkapAttribute()
    {
        return $this->nama . ' (' . $this->nisn . ')';
    }
}
