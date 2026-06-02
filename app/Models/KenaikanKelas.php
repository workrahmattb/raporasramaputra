<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KenaikanKelas extends Model
{
    use HasFactory;

    protected $table = 'kenaikan_kelas';

    protected $fillable = [
        'siswa_id',
        'semester_id',
        'keputusan',
        'naik_ke_kelas',
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
}
