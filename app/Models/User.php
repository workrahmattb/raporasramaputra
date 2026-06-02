<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'sekolah_id',
        'role',
        'session_tahun_ajaran_id',
        'session_semester_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    // Relationships
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function guruProfile()
    {
        return $this->hasOne(GuruRapor::class);
    }

    public function kelasWali()
    {
        return $this->hasMany(KelasRapor::class, 'wali_kelas_id');
    }

    public function sessionTahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'session_tahun_ajaran_id');
    }

    public function sessionSemester()
    {
        return $this->belongsTo(Semester::class, 'session_semester_id');
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isGuru()
    {
        return $this->role === 'guru';
    }

    public function isWaliKelas()
    {
        if ($this->role === 'wali_kelas') {
            return true;
        }

        if ($this->role === 'guru' && $this->guruProfile) {
            return $this->guruProfile->kelasWali()->exists();
        }

        return false;
    }

    public function hasSelectedAcademicPeriod()
    {
        return !is_null($this->session_tahun_ajaran_id) && !is_null($this->session_semester_id);
    }

    public function getSessionTahunAjaran()
    {
        return $this->sessionTahunAjaran;
    }

    public function getSessionSemester()
    {
        return $this->sessionSemester;
    }

    public function setSessionAcademicPeriod($tahunAjaranId, $semesterId)
    {
        $this->update([
            'session_tahun_ajaran_id' => $tahunAjaranId,
            'session_semester_id' => $semesterId,
        ]);
    }
}
