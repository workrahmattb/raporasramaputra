<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiSikap extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'semester_id',
        'sikap_spiritual',
        'sikap_sosial',
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
