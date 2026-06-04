<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'kelas_id',
        'mata_pelajaran_id',
        'semester_id',
        'guru_id',
        'nilai_pengetahuan',
    ];

    // Relationships
    public function siswa()
    {
        return $this->belongsTo(SiswaRapor::class, 'siswa_id');
    }

    public function kelas()
    {
        return $this->belongsTo(KelasRapor::class, 'kelas_id');
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    public function guru()
    {
        return $this->belongsTo(GuruRapor::class, 'guru_id');
    }

    // Accessors
    public function getRataRataAttribute()
    {
        return $this->nilai_pengetahuan;
    }
}
