# 🧠 Project Memory — Rapor PPSR

## 📌 Informasi Project

- **Nama:** Sistem Informasi Rapor Pondok Pesantren Syafa'aturrasul (PPSR)
- **Stack:** Laravel 12 + Livewire 4 + Tailwind CSS 4 + Vite + Laravel Fortify
- **Deskripsi:** Sistem manajemen rapor pesantren dengan fitur input nilai, kehadiran, catatan wali kelas, cetak rapor PDF, dan export Excel leger kelas.
- **Role:** admin, guru (pembina asrama), wali_kelas (wali asrama)

---

## 📋 Review Project (2026-06-09)

### Struktur Database Inti
```
sekolahs
  └── users (dengan role & session akademik)
  └── tahun_ajarans → semesters
  └── siswas_rapor (soft deletes)
  └── gurus_rapor (soft deletes)
  └── mata_pelajarans
  └── kelas_rapor ──┬── kelas_siswa (pivot) ── siswas_rapor
                     └── wali_kelas_id → gurus_rapor

nilais (siswa_id, kelas_id, mapel_id, semester_id, guru_id)
nilai_sikaps (siswa_id, semester_id)
kehadirans (siswa_id, semester_id, sakit, izin, tanpa_keterangan)
catatan_wali_kelas (siswa_id, semester_id, wali_kelas_id, catatan)
kenaikan_kelas (siswa_id, semester_id, keputusan, naik_ke_kelas)
rapor_settings (singleton)
```

### Kekuatan
- Arsitektur clean Laravel + Livewire murni
- Role system terdefinisi jelas (admin, guru, wali_kelas)
- PDF generation dengan laravel-mpdf (F4 size)
- Excel export dengan maatwebsite/excel (styling profesional)
- Sidebar responsive, Tailwind CSS, mobile-friendly
- Soft deletes pada siswa & guru
- Session academic period disimpan di user (filtering data)

### Area Perlu Perbaikan
- Duplikasi signifikan: Admin/Leger vs WaliKelas/Leger (~90%), Admin/Rapor vs WaliKelas/Rapor (~95%)
- Inkonsistensi migration (sekolah_id, kolom nama vs tahun)
- Penggunaan DB::table() mentah di beberapa komponen (stdClass, bukan Model)
- Validasi kurang (guru_id bisa null, catatan tanpa validasi input)
- Error handling tidak konsisten (abort(400) vs abort(404))
- Route Model Binding tidak digunakan
- Belum ada unit / feature tests

---

## 🔧 Perbaikan SPA Navigation (2026-06-09)

### Masalah
Beberapa navigasi masih menggunakan **full page reload** alih-alih **Livewire SPA** (`wire:navigate`), menyebabkan pengalaman pengguna kurang mulus.

### Perubahan yang Dilakukan

#### 📄 `resources/views/layouts/app.blade.php` (3 perubahan)
1. **Baris 113** — Link Dashboard untuk role **Guru**: tambah `wire:navigate`
2. **Baris 135** — Link Dashboard untuk role **Wali Kelas**: tambah `wire:navigate`
3. **Baris ~200** — Link Profile di dropdown user: tambah `wire:navigate`

#### 🔄 `app/Livewire/SelectAcademicPeriod.php`
- `return redirect()->route('dashboard')` → `$this->redirectRoute('dashboard', navigate: true)`

#### 🔄 `app/Livewire/Guru/InputNilai/Form.php`
- `return redirect()->route('guru.input-nilai.index')` → `$this->redirectRoute('guru.input-nilai.index', navigate: true)` + `return;`

#### 🔄 `app/Livewire/WaliKelas/Kehadiran/Form.php`
- `return redirect()->route('wali-kelas.kehadiran.index')` → `$this->redirectRoute('wali-kelas.kehadiran.index', navigate: true)`

#### 🔄 `app/Livewire/WaliKelas/Catatan/Form.php`
- `return redirect()->route('wali-kelas.catatan.index')` → `$this->redirectRoute('wali-kelas.catatan.index', navigate: true)`

#### 🔄 `app/Livewire/Admin/Siswa/Create.php`
- `return redirect()->route('admin.siswa.index')` → `$this->redirectRoute('admin.siswa.index', navigate: true)`

#### 🔄 `app/Livewire/Admin/TahunAjaran/Create.php`
- `return redirect()->route('admin.tahun-ajaran.index')` → `$this->redirectRoute('admin.tahun-ajaran.index', navigate: true)`

#### 🔄 `app/Livewire/Admin/TahunAjaran/Edit.php`
- `return redirect()->route('admin.tahun-ajaran.index')` → `$this->redirectRoute('admin.tahun-ajaran.index', navigate: true)`

#### 🔄 `app/Livewire/Admin/Kelas/Create.php`
- `return redirect()->route('admin.kelas.index')` → `$this->redirectRoute('admin.kelas.index', navigate: true)`

#### 🔄 `app/Livewire/Admin/Kelas/Edit.php`
- `return redirect()->route('admin.kelas.index')` → `$this->redirectRoute('admin.kelas.index', navigate: true)`

### Total
- **12 perubahan** di 10 file
- **3** tambah `wire:navigate` di Blade
- **9** ubah redirect ke `navigate: true` di Livewire Components
- ✅ Semua syntax valid
- ✅ Alur bisnis tidak berubah
