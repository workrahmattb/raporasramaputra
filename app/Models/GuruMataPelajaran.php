<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruMataPelajaran extends Model
{
    use HasFactory;

    protected $table = 'guru_mata_pelajaran';

    protected $fillable = [
        'guru_id',
        'mata_pelajaran_id',
        'tingkat',
    ];

    // Relationships
    public function guru()
    {
        return $this->belongsTo(GuruRapor::class, 'guru_id');
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }

    public function kelas()
    {
        return $this->hasMany(KelasRapor::class, 'tingkat', 'tingkat');
    }
}
