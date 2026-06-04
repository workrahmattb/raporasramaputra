<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Rapor - {{ $kelas->nama }} - {{ $semester->nama }}</title>
    <style>
        @page {
            margin: 10mm 15mm;
            size: 215mm 330mm;
        }
        
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10pt;
            color: #000;
            line-height: 1.3;
        }

        .page-break {
            page-break-after: always;
        }

        .header-table {
            width: 100%;
            border-bottom: 4px solid #000;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }
        
        .logo-img {
            width: 100px;
            height: auto;
        }
        
        .header-text {
            text-align: center;
        }
        
        .header-title {
            font-size: 24pt;
            font-weight: 800;
            margin: 0;
            letter-spacing: 1px;
        }
        
        .header-subtitle {
            font-size: 14pt;
            font-weight: 600;
            margin: 5px 0;
        }

        .identity-box {
            margin-bottom: 20px;
        }

        .identity-table {
            width: 100%;
            border: none;
            border-collapse: collapse;
        }

        .identity-table td {
            padding: 3px 6px;
            vertical-align: top;
            border: none;
        }

        .label {
            font-weight: bold;
            width: 140px;
        }

        .separator {
            width: 15px;
            text-align: center;
        }

        .value {
            font-weight: 500;
        }

        .section-header {
            padding: 8px 15px;
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 15px;
            display: inline-block;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            border: 4px double #000;
            table-layout: fixed;
        }

        .data-table th {
            background-color: #f5f5f5;
            padding: 10px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9pt;
            border: 1px solid #000;
        }

        .data-table td {
            padding: 8px 10px;
            border: 1px solid #000;
            font-size: 10pt;
        }

        .center { text-align: center; }
        .right { text-align: right; }

        .grade-score {
            font-weight: bold;
        }

        .deskripsi-subject {
            font-size: 9pt;
            color: #555;
            font-style: italic;
        }

        .no-col {
            width: 8%;
            text-align: center;
            vertical-align: middle;
            font-weight: 500;
        }

        .notes {
            border: 2px dashed #000;
            padding: 15px;
            min-height: 60px;
        }

        .footer-table {
            width: 100%;
            margin-top: 40px;
            page-break-inside: avoid;
        }
        
        .sign-col {
            width: 25%;
            text-align: center;
            vertical-align: top;
        }
        
        .date-line {
            text-align: right;
            margin-bottom: 10px;
            padding-right: 20px;
        }
        
        .sign-role {
            font-size: 10pt;
            font-weight: bold;
        }

        .sign-spacer {
            height: 250px;
        }
        
        .sign-name {
            font-weight: bold;
            font-size: 13pt;
        }
    </style>
</head>
<body>

@foreach($allRaporData as $index => $raporData)
    @php
        $siswa = $raporData['siswa'];
        $nilais = $raporData['nilais'];
        $nilaiSikap = $raporData['nilaiSikap'];
        $kehadiran = $raporData['kehadiran'];
        $catatan = $raporData['catatan'];
    @endphp

    <!-- Header -->
    <table class="header-table">
        <tr>
            <td width="15%" align="center">
                <img src="{{ public_path('img/logo-ppsr.png') }}" class="logo-img">
            </td>
            <td width="85%" align="center">
                <div class="header-text">
                    <h1 class="header-title">RAPOR ASRAMA</h1>
                    <h2 class="header-subtitle">PONDOK PESANTREN SYAFA'ATURRASUL</h2>
                </div>
            </td>
        </tr>
    </table>

    <!-- Identity -->
    <div class="identity-box">
        <table class="identity-table">
            <tr>
                <td class="label">Nama Siswa</td>
                <td class="separator">:</td>
                <td class="value">{{ $siswa->nama }}</td>
            </tr>
            <tr>
                <td class="label">NISN</td>
                <td class="separator">:</td>
                <td class="value">{{ $siswa->nisn ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Tahun Ajaran</td>
                <td class="separator">:</td>
                <td class="value">{{ $semester->tahunAjaran->tahun ?? '-' }}</td>
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
                <td class="label">Wali Asrama</td>
                <td class="separator">:</td>
                <td class="value">{{ $kelas->waliKelas->nama ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <!-- Academic Scores -->
    <div class="section-header">PENCAPAIAN KOMPETENSI DAN HASIL BELAJAR</div>
    
    @if(count($nilais) > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th class="center" width="8%">No</th>
                    <th width="35%">Aspek Penilaian<br><span style="font-weight:normal;font-size:8pt">(Assessment Aspect)</span></th>
                    <th width="37%">Indikator<br><span style="font-weight:normal;font-size:8pt">(Indicator)</span></th>
                    <th class="center" width="20%">Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach($nilais as $nilaiIndex => $nilai)
                    @php
                        $nilaiPengetahuan = $nilai->nilai_pengetahuan ?? 0;
                        $isEmptyNilai = empty($nilaiPengetahuan) || $nilaiPengetahuan == 0;
                    @endphp
                    <tr>
                        <td class="no-col">{{ $nilaiIndex + 1 }}</td>
                        <td>{{ $nilai->mataPelajaran->nama ?? '-' }}</td>
                        <td class="deskripsi-subject">{{ $nilai->mataPelajaran->deskripsi ?? '-' }}</td>
                        <td class="center grade-score">{{ $isEmptyNilai ? '-' : number_format($nilaiPengetahuan, 0) }}</td>
                    </tr>
                @endforeach
                
                @php
                    $totalNilai = 0;
                    $countNilai = 0;
                    
                    foreach($nilais as $nilai) {
                        $nilaiPengetahuan = $nilai->nilai_pengetahuan ?? 0;
                        if ($nilaiPengetahuan > 0) {
                            $totalNilai += $nilaiPengetahuan;
                            $countNilai++;
                        }
                    }
                    
                    $average = $countNilai > 0 ? round($totalNilai / $countNilai, 2) : 0;
                @endphp
                
                <tr style="font-weight: bold; border: 1px solid #000;">
                    <td colspan="2" class="center">Jumlah</td>
                    <td></td>
                    <td class="center grade-score">{{ $totalNilai > 0 ? number_format($totalNilai, 0) : '-' }}</td>
                </tr>
                
                <tr style="font-weight: bold; border: 1px solid #000;">
                    <td colspan="2" class="center">Rata-rata</td>
                    <td></td>
                    <td class="center grade-score">{{ $average > 0 ? number_format($average, 2) : '-' }}</td>
                </tr>
            </tbody>
        </table>
    @else
        <p class="center" style="font-style: italic; color: #777; margin: 20px;">Belum ada data nilai</p>
    @endif

    <!-- Notes -->
    <div class="section-header">CATATAN WALI ASRAMA</div>
    <div class="notes">
        @if($catatan && $catatan->catatan)
            {{ $catatan->catatan }}
        @else
            <span style="color: #999; font-style: italic;">Tidak ada catatan.</span>
        @endif
    </div>

    <!-- Signatures -->
    <div class="date-line">
        <span>{{ $settings->tanggal_rapor ?? now()->locale('id')->isoFormat('D MMMM YYYY') }}</span>
    </div>
    
    <table class="footer-table">
        <tr>
            <td class="sign-col">
                <div class="sign-role">PIMPINAN PONDOK PESANTREN</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-name">{{ $settings->pimpinan_pondok ?? '-' }}</div>
            </td>
            <td class="sign-col">
                <div class="sign-role">KEPALA PENGASUHAN ASRAMA</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-name">{{ $settings->kepala_pengasuhan_asrama ?? '-' }}</div>
            </td>
            <td class="sign-col">
                <div class="sign-role">WALI ASRAMA</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-name">
                    {{ $kelas->waliKelas->nama ?? '' }}
                </div>
            </td>
            <td class="sign-col">
                <div class="sign-role">ORANG TUA / WALI</div>  
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-name"></div>
            </td>
        </tr>
    </table>

    @if($index < count($allRaporData) - 1)
        <div class="page-break"></div>
    @endif
@endforeach

</body>
</html>
