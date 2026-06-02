<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasRapor extends Model
{
    use HasFactory;

    protected $table = 'kelas_rapor';

    protected $fillable = [
        'tahun_ajaran_id',
        'wali_kelas_id',
        'nama',
        'tingkat',
    ];

    // Relationships
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function waliKelas()
    {
        return $this->belongsTo(GuruRapor::class, 'wali_kelas_id');
    }

    public function siswas()
    {
        return $this->belongsToMany(SiswaRapor::class, 'kelas_siswa', 'kelas_id', 'siswa_id')
                    ->withPivot('nomor_absen')
                    ->withTimestamps();
    }

    public function guruMataPelajaran()
    {
        return $this->hasMany(GuruMataPelajaran::class, 'tingkat', 'tingkat');
    }

    public function nilais()
    {
        return $this->hasMany(Nilai::class, 'kelas_id');
    }

    // Accessors
    public function getNamaLengkapAttribute()
    {
        return $this->nama . ' - ' . $this->tahunAjaran->tahun;
    }
}
