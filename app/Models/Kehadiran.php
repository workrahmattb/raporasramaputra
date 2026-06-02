<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'semester_id',
        'sakit',
        'izin',
        'tanpa_keterangan',
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

    // Accessors
    public function getTotalAbsenAttribute()
    {
        return $this->sakit + $this->izin + $this->tanpa_keterangan;
    }
}
