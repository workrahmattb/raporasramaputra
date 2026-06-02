<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Sekolah::create([
            'nama' => 'Pondok Pesantren Salafiyah Raudlatusysyubban',
            'npsn' => '69987654',
            'alamat' => 'Jl. Raya Pendidikan No. 123, Kota',
            'telepon' => '021-12345678',
            'email' => 'info@ppsr.sch.id',
            'kepala_sekolah' => 'Drs. Ahmad Fauzi, M.Pd',
            'nip_kepala_sekolah' => '196501011990031001',
            'logo' => null,
        ]);
    }
}
