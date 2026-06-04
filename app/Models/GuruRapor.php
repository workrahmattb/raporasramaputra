<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GuruRapor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'gurus_rapor';

    protected $fillable = [
        'sekolah_id',
        'user_id',
        'nip',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'telepon',
        'email',
        'pendidikan_terakhir',
        'tanggal_mulai_mengajar',
        'status',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_mulai_mengajar' => 'date',
    ];

    // Relationships
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelasWali()
    {
        return $this->hasMany(KelasRapor::class, 'wali_kelas_id');
    }

    public function nilais()
    {
        return $this->hasMany(Nilai::class, 'guru_id');
    }

    public function catatanWaliKelas()
    {
        return $this->hasMany(CatatanWaliKelas::class, 'wali_kelas_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'Aktif');
    }
}
