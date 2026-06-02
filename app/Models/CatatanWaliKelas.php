<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanWaliKelas extends Model
{
    use HasFactory;

    protected $table = 'catatan_wali_kelas';

    protected $fillable = [
        'siswa_id',
        'semester_id',
        'wali_kelas_id',
        'catatan',
    ];

    // Relationships
    public function siswa()
    {
        return $this->belongsTo(SiswaRapor::class, 'siswa_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    public function waliKelas()
    {
        return $this->belongsTo(GuruRapor::class, 'wali_kelas_id');
    }
}
