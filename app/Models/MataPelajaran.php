<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'sekolah_id',
        'kode',
        'nama',
        'namapelajaran_arabic',
        'kelompok',
        'tingkat',
        'kkm',
    ];

    // Relationships
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function gurus()
    {
        return $this->belongsToMany(GuruRapor::class, 'guru_mata_pelajaran', 'mata_pelajaran_id', 'guru_id')
                    ->withPivot('tingkat')
                    ->withTimestamps();
    }

    public function nilais()
    {
        return $this->hasMany(Nilai::class, 'mata_pelajaran_id');
    }

    // Scopes
    public function scopeKelompok($query, $kelompok)
    {
        return $query->where('kelompok', $kelompok);
    }

    public function scopeTingkat($query, $tingkat)
    {
        return $query->where('tingkat', $tingkat);
    }
}
