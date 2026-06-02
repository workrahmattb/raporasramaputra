<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun_ajaran_id',
        'nama',
        'is_active',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    // Relationships
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function nilais()
    {
        return $this->hasMany(Nilai::class);
    }

    public function nilaiSikaps()
    {
        return $this->hasMany(NilaiSikap::class);
    }

    public function kehadirans()
    {
        return $this->hasMany(Kehadiran::class);
    }

    public function catatanWaliKelas()
    {
        return $this->hasMany(CatatanWaliKelas::class);
    }

    public function kenaikanKelas()
    {
        return $this->hasMany(KenaikanKelas::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessors
    public function getNamaLengkapAttribute()
    {
        $tahunAjaran = $this->tahunAjaran->tahun ?? '';
        return $tahunAjaran . ' - ' . $this->nama;
    }
}
