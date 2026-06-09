<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Rapor - {{ $siswa->nama }}</title>
    <style>
        @page {
            margin: 8mm 12mm;
            size: 215mm 330mm;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 7.5pt;
            color: #000;
            line-height: 1.15;
        }

        .header-table {
            width: 100%;
            border-bottom: 3px solid #000;
            margin-bottom: 8px;
            padding-bottom: 6px;
        }

        .logo-img {
            width: 80px;
            height: auto;
        }

        .header-text {
            text-align: center;
        }
        
        .header-yayasan {
            font-size: 11pt;
            font-weight: 700;
            margin: 0;
            letter-spacing: 0.5px;
        }
        
        .header-subtitle {
            font-size: 14pt;
            font-weight: 800;
            margin: 3px 0;
        }
        
        .header-address {
            font-size: 9pt;
            margin: 1px 0;
            color: #444;
        }

        .identity-box {
            margin-bottom: 6px;
        }

        .identity-table {
            width: 100%;
            border: none;
            border-collapse: collapse;
        }

        .identity-table td {
            padding: 1px 4px;
            vertical-align: top;
            border: none;
        }

        .label {
            font-weight: bold;
            width: 100px;
        }

        .separator {
            width: 10px;
            text-align: center;
        }

        .value {
            font-weight: 500;
        }

        .report-title {
            text-align: center;
            margin-bottom: 6px;
        }

        .report-title-main {
            font-size: 9pt;
            font-weight: bold;
            line-height: 1.2;
        }

        .report-title-sub {
            font-size: 6.5pt;
            font-style: italic;
            color: #444;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
            border: 2px double #000;
            table-layout: fixed;
        }

        .data-table th {
            background-color: #f5f5f5;
            padding: 4px 4px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 6.5pt;
            border: 1px solid #000;
        }

        .data-table td {
            padding: 3px 5px;
            border: 1px solid #000;
            font-size: 7.5pt;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .grade-score {
            font-weight: bold;
        }

        .deskripsi-subject {
            font-size: 6.5pt;
            color: #555;
            font-style: italic;
        }

        .no-col {
            width: 8%;
            text-align: center;
            vertical-align: middle;
            font-weight: 500;
        }

        .notes-box {
            border: 1.5px dashed #000;
            padding: 6px 8px;
            min-height: 28px;
            margin-top: 2px;
        }

        .notes-label {
            font-size: 8pt;
            font-weight: bold;
            margin-bottom: 0;
        }

        .footer-signatures {
            width: 100%;
            margin-top: 2px;
            border-collapse: collapse;
        }

        .footer-signatures td {
            vertical-align: top;
            padding: 0 10px;
        }

        .sign-left {
            width: 50%;
            text-align: left;
        }
        
        .sign-right {
            width: 50%;
            text-align: right;
        }
        
        .sign-center {
            width: 100%;
            text-align: center;
        }

        .date-line {
            text-align: right;
            margin-bottom: 4px;
            font-size: 7pt;
        }
        
        .sign-role {
            font-size: 6pt;
            font-weight: normal;
        }
        
        .sign-name {
            font-weight: bold;
            font-size: 8pt;
            text-decoration: underline;
        }

        .sign-spacer {
            height: 18px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <table class="header-table">
        <tr>
            <td width="15%" align="center">
                <img src="{{ public_path('img/logo-ppsr.png') }}" class="logo-img">
            </td>
            <td width="85%" align="center">
                <div class="header-text">
                    <div class="header-yayasan">YAYASAN WAKAF SYAFA'ATURRASUL MADANI</div>
                    <div class="header-subtitle">PONDOK PESANTREN SYAFA'ATURRASUL 2 PUTRA</div>
                    <div class="header-address">Desa Jalur Patah, Kecamatan Sentajo Raya</div>
                    <div class="header-address">Kabupaten Kuantan Singingi - Riau</div>
                </div>
            </td>
        </tr>
    </table>

    <!-- Report Title -->
    <div class="report-title">
        <div class="report-title-main">LAPORAN PENILAIAN SIKAP KEPRIBADIAN DAN SOSIAL SANTRI</div>
        <div class="report-title-sub">(Assessment Report of Students' Religious and Social Behavior)</div>
    </div>

    <!-- Identity -->
    <div class="identity-box">
        <table class="identity-table">
            <tr>
                <td class="label">Nama Siswa</td>
                <td class="separator">:</td>
                <td class="value">{{ $siswa->nama }}</td>
            </tr>
            <tr>
                <td class="label">Asrama</td>
                <td class="separator">:</td>
                <td class="value">{{ $kelas->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Semester</td>
                <td class="separator">:</td>
                <td class="value">{{ $semester->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Tahun Ajaran</td>
                <td class="separator">:</td>
                <td class="value">{{ $semester->tahunAjaran->tahun ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <!-- Academic Scores -->
    @if(count($nilais) > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th class="center" width="8%">No</th>
                    <th width="35%">Aspek Penilaian<br><span style="font-weight:normal;font-size:6pt">(Assessment Aspect)</span></th>
                    <th width="37%">Indikator<br><span style="font-weight:normal;font-size:6pt">(Indicator)</span></th>
                    <th class="center" width="20%">Nilai<br><span style="font-weight:normal;font-size:6pt">(Score)</span></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($nilais as $index => $nilai)
                    @php
                        $nilaiPengetahuan = $nilai->nilai_pengetahuan ?? 0;
                        $isEmptyNilai = empty($nilaiPengetahuan) || $nilaiPengetahuan == 0;
                    @endphp
                    <tr>
                        <td class="no-col">{{ $index + 1 }}</td>
                        <td>{{ $nilai->mataPelajaran->nama ?? '-' }}</td>
                        <td class="deskripsi-subject">{{ $nilai->mataPelajaran->deskripsi ?? '-' }}</td>
                        <td class="center grade-score">{{ $isEmptyNilai ? '-' : number_format($nilaiPengetahuan, 0) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="center" style="font-style: italic; color: #777; margin: 10px;">Belum ada data nilai</p>
    @endif

    <!-- Notes -->
    <div class="notes-label">CATATAN MUSRIF</div>
    <div class="notes-box">
        @if ($catatan && $catatan->catatan)
            {{ $catatan->catatan }}
        @else
            <span style="color: #999; font-style: italic;">Tidak ada catatan.</span>
        @endif
    </div>

    <!-- Date -->
    <div class="date-line">
        <span>{{ $settings->tanggal_rapor ?? now()->locale('id')->isoFormat('D MMMM YYYY') }}</span>
    </div>

    <!-- Signatures -->
    <!-- Row 1: Orang Tua (Kiri) + Pembina Asrama (Kanan) -->
    <table class="footer-signatures">
        <tr>
            <td class="sign-left">
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-name">{{ $siswa->nama_ayah ?? '-' }}</div>
                <div class="sign-role">ORANG TUA / WALI</div>
            </td>
            <td class="sign-right">
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-name">{{ $kelas->waliKelas->nama ?? '' }}</div>
                <div class="sign-role">PEMBINA ASRAMA</div>
            </td>
        </tr>
    </table>

    <!-- Row 2: Mengetahui (Tengah) -->
    <table class="footer-signatures">
        <tr>
            <td class="sign-center">
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-name"></div>
                <div class="sign-role">MENGETAHUI</div>
            </td>
        </tr>
    </table>

    <!-- Row 3: Kepala Pengasuhan Asrama (Kiri) + Pimpinan Pondok (Kanan) -->
    <table class="footer-signatures">
        <tr>
            <td class="sign-left">
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-name">{{ $settings->kepala_pengasuhan_asrama ?? '-' }}</div>
                <div class="sign-role">KEPALA PENGASUHAN ASRAMA</div>
            </td>
            <td class="sign-right">
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-name">{{ $settings->pimpinan_pondok ?? '-' }}</div>
                <div class="sign-role">PIMPINAN PONDOK PESANTREN</div>
            </td>
        </tr>
    </table>

</body>

</html>
