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

---

## 📄 Perbaikan Layout Cetak Rapor PDF (2026-06-09)

### Masalah
Cetak rapor PDF tidak muat dalam 1 halaman F4 (215mm x 330mm), font terlalu besar, layout signature tidak rapi.

### Perubahan yang Dilakukan

#### 3 File Print Rapor Diperbaiki:
1. `resources/views/livewire/admin/rapor/print.blade.php` — Single print admin
2. `resources/views/livewire/wali-kelas/rapor/print.blade.php` — Single print wali kelas
3. `resources/views/livewire/admin/rapor/print-all.blade.php` — Print all class

#### Detail Pengecilan Layout (1 Halaman F4):

| Elemen | Sebelum | Sesudah |
|--------|---------|---------|
| Body font | 10pt | **7.5pt** |
| Line-height | 1.3 | **1.15** |
| Margin @page | 10mm 15mm | **8mm 12mm** |
| Yayasan header | 13pt → **11pt** | diperbesar |
| Subtitle pondok | 16pt → **14pt** | diperbesar |
| Alamat | 10pt → **9pt** | diperbesar |
| Logo | 100px → **80px** | diperbesar |
| Title rapor | 14pt | **9pt** |
| Border header | 2px | **3px** |
| Padding tabel th | 10px | **4px** |
| Padding tabel td | 8px 10px | **3px 5px** |
| Border tabel | 4px double | **2px double** |
| Notes min-height | 60px | **28px** |
| Signature spacer | 40px | **18px** |
| Ukuran kertas | F4 | **Tetap F4 (215×330mm)** |

#### Penyesuaian Signature Spacer:
- Awal: 3 `sign-spacer` per cell
- Dinaikkan ke 7, lalu 13 (ternyata terlalu banyak)
- **Final: 10 `sign-spacer`** per cell ✅

#### Signature Orang Tua Terisi Nama Ayah:
- `$siswa->nama_ayah` dari model SiswaRapor (field `nama_ayah`) ✅
- Ditampilkan di signature Orang Tua / Wali, bukan placeholder kosong

#### Tata Letak Signature Final:
```
┌─────────────────────┬─────────────────────┐
│  ORANG TUA / WALI   │   PEMBINA ASRAMA    │
│  $siswa->nama_ayah  │   (nama)            │
└─────────────────────┴─────────────────────┘
┌───────────────────────────────────────────┐
│              MENGETAHUI                   │
│              (placeholder)                │
└───────────────────────────────────────────┘
┌─────────────────────┬─────────────────────┐
│  KEPALA PENGASUHAN  │   PIMPINAN PONDOK   │
│  ASRAMA             │   PESANTREN         │
│  (nama)             │   (nama)            │
└─────────────────────┴─────────────────────┘
```

- ✅ Orang Tua / Wali — **kiri atas** (isi: `nama_ayah`)
- ✅ Pembina Asrama — **kanan atas**
- ✅ Mengetahui — **tengah**
- ✅ Kepala Pengasuhan Asrama — **kiri bawah**
- ✅ Pimpinan Pondok Pesantren — **kanan bawah**
- ✅ CSS baru: `.sign-left`, `.sign-right`, `.sign-center`
- ✅ CSS lama (`.sign-col-center`, `.sign-row-2-left/right`) dibersihkan
- ✅ Semua syntax valid
