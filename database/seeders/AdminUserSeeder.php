<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sekolah = \App\Models\Sekolah::first();
        
        \App\Models\User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@ppsr.sch.id',
            'password' => bcrypt('admin123'),
            'sekolah_id' => $sekolah->id,
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
    }
}
