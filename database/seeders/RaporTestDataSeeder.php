<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Sekolah;
use App\Models\TahunAjaran;
use App\Models\Semester;
use App\Models\KelasRapor;
use App\Models\GuruRapor;
use App\Models\SiswaRapor;
use App\Models\MataPelajaran;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RaporTestDataSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('Creating test data for Rapor system...');

        // Get or create sekolah
        $sekolah = Sekolah::first();
        if (!$sekolah) {
            $sekolah = Sekolah::create([
                'nama' => 'Pondok Pesantren Syafa\'aturrasul',
                'npsn' => '12345678',
                'alamat' => 'Jl. Test No. 123',
                'telepon' => '021-12345678',
                'email' => 'ppsr@test.com',
            ]);
            $this->command->info('✓ Sekolah created');
        }

        // Create or get active tahun ajaran
        $tahunAjaran = TahunAjaran::where('is_active', true)->first();
        if (!$tahunAjaran) {
            $tahunAjaran = TahunAjaran::create([
                'nama' => '2025/2026',
                'tanggal_mulai' => '2025-07-01',
                'tanggal_selesai' => '2026-06-30',
                'is_active' => true
            ]);
            $this->command->info('✓ Tahun Ajaran created: ' . $tahunAjaran->nama);
        }

        // Create active semester
        $semester = Semester::where('is_active', true)->first();
        if (!$semester) {
            $semester = Semester::create([
                'tahun_ajaran_id' => $tahunAjaran->id,
                'nama' => 'Semester 1 - ' . $tahunAjaran->nama,
                'jenis' => 'Ganjil',
                'tanggal_mulai' => $tahunAjaran->tanggal_mulai,
                'tanggal_selesai' => now()->addMonths(6),
                'is_active' => true
            ]);
            $this->command->info('✓ Semester created: ' . $semester->nama);
        }

        // Create kelas
        $kelas = KelasRapor::where('tahun_ajaran_id', $tahunAjaran->id)
            ->where('nama', 'VII-A')
            ->first();
        
        if (!$kelas) {
            $kelas = KelasRapor::create([
                'sekolah_id' => $sekolah->id,
                'tahun_ajaran_id' => $tahunAjaran->id,
                'nama' => 'VII-A',
            ]);
            $this->command->info('✓ Kelas created: ' . $kelas->nama);
        }

        // Create guru user and GuruRapor
        $guruUser = User::where('email', 'guru@test.com')->first();
        if (!$guruUser) {
            $guruUser = User::create([
                'sekolah_id' => $sekolah->id,
                'name' => 'Guru Test',
                'email' => 'guru@test.com',
                'password' => Hash::make('guru123'),
                'role' => 'guru'
            ]);

            $guru = GuruRapor::create([
                'sekolah_id' => $sekolah->id,
                'user_id' => $guruUser->id,
                'nip' => '987654321',
                'nama' => 'Guru Test',
                'jenis_kelamin' => 'L',
                'email' => 'guru@test.com',
                'telepon' => '081234567890',
                'status' => 'Aktif'
            ]);

            $this->command->info('✓ Guru user created: guru@test.com / guru123');
        } else {
            $guru = GuruRapor::where('user_id', $guruUser->id)->first();
            $this->command->info('✓ Guru user exists: guru@test.com');
        }

        // Assign guru as wali kelas
        if (!$kelas->wali_kelas_id) {
            $kelas->update(['wali_kelas_id' => $guru->id]);
            $this->command->info('✓ Guru assigned as wali kelas for ' . $kelas->nama);
        }

        // Get or create mata pelajaran
        $mapel = MataPelajaran::where('nama', 'Matematika')->first();
        if (!$mapel) {
            $mapel = MataPelajaran::create([
                'sekolah_id' => $sekolah->id,
                'kode' => 'MTK',
                'nama' => 'Matematika',
                'kkm' => 75,
            ]);
            $this->command->info('✓ Mata Pelajaran created: Matematika');
        }

        // Create sample students
        $siswaNames = [
            ['nama' => 'Ahmad Fauzi', 'nisn' => '1234567890', 'jk' => 'L'],
            ['nama' => 'Fatimah Zahra', 'nisn' => '1234567891', 'jk' => 'P'],
            ['nama' => 'Muhammad Ali', 'nisn' => '1234567892', 'jk' => 'L'],
        ];

        foreach ($siswaNames as $index => $data) {
            $siswa = SiswaRapor::where('nisn', $data['nisn'])->first();
            
            if (!$siswa) {
                $siswa = SiswaRapor::create([
                    'sekolah_id' => $sekolah->id,
                    'nisn' => $data['nisn'],
                    'nama' => $data['nama'],
                    'jenis_kelamin' => $data['jk'],
                    'tempat_lahir' => 'Jakarta',
                    'tanggal_lahir' => '2010-01-15',
                    'status' => 'Aktif'
                ]);
                $this->command->info('✓ Siswa created: ' . $siswa->nama);
            }

            // Enroll siswa in kelas
            $enrolled = DB::table('kelas_siswa')
                ->where('kelas_id', $kelas->id)
                ->where('siswa_id', $siswa->id)
                ->exists();

            if (!$enrolled) {
                DB::table('kelas_siswa')->insert([
                    'kelas_id' => $kelas->id,
                    'siswa_id' => $siswa->id,
                    'nomor_absen' => $index + 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                $this->command->info('✓ Siswa enrolled: ' . $siswa->nama . ' in ' . $kelas->nama);
            }
        }

        $this->command->info('');
        $this->command->info('=== Test Data Summary ===');
        $this->command->info('Tahun Ajaran: ' . $tahunAjaran->nama);
        $this->command->info('Semester: ' . $semester->nama);
        $this->command->info('Kelas: ' . $kelas->nama);
        $this->command->info('Wali Kelas: guru@test.com / guru123');
        $this->command->info('Mata Pelajaran: ' . $mapel->nama);
        $this->command->info('Siswa: 3 students enrolled');
        $this->command->info('');
        $this->command->info('✅ Ready to test!');
        $this->command->info('1. Login as guru@test.com / guru123');
        $this->command->info('2. Go to \"Input Nilai\" to enter grades');
        $this->command->info('3. Go to \"Cetak Rapor\" to preview and print report cards');
    }
}
