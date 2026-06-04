<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RaporSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal_rapor',
        'kepala_pengasuhan_asrama',
        'pimpinan_pondok',
    ];

    /**
     * Get the single settings record (singleton pattern)
     */
    public static function getSettings()
    {
        return self::firstOrCreate(
            ['id' => 1],
            [
                'tanggal_rapor' => 'Teluk Kuantan, ' . now()->locale('id')->isoFormat('D MMMM YYYY'),
                'kepala_pengasuhan_asrama' => 'Mardiah Resnilawati Ningsih, S.Pd',
                'pimpinan_pondok' => 'Dina Yulesti, M.Pd',
            ]
        );
    }
}
