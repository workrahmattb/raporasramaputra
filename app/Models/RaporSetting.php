<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RaporSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal_rapor',
        'kepala_sekolah_mts',
        'kepala_sekolah_ma',
    ];

    /**
     * Get the single settings record (singleton pattern)
     */
    public static function getSettings()
    {
        return self::firstOrCreate(
            ['id' => 1],
            [
                'tanggal_rapor' => '٢ محرم ١٤٤٨, تلوك كوانتن',
                'kepala_sekolah_mts' => 'S.Pd مارديه روسنيله نينغسيه',
                'kepala_sekolah_ma' => 'Dina Yulesti, M.Pd',
            ]
        );
    }
}
