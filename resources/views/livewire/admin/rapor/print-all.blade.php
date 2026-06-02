<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Rapor - {{ $kelas->nama }} - {{ $semester->nama }}</title>
    <style>
        @page {
            margin: 10mm 15mm;
            size: 215mm 330mm; /* F4/Folio */
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

        /* Header Styles */
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
            color: #020302ff;
        }
        
        .header-title {
            font-size: 29pt;
            font-weight: 800;
            margin: 0;
            letter-spacing: 1px;
            font-family: DejaVu Sans
        }
        
        .header-subtitle {
            font-size: 25pt;
            font-weight: 600;
            margin: 5px 0;
            color: #030303ff;
            font-family: DejaVu Sans
        }
        
        .header-address {
            font-size: 9pt;
            margin: 0;
            color: #000;
        }

        /* Identity Section */
        .identity-box {
            background-color: #fff;
            border: 3px double #000;
            border-radius: 0px;
            padding: 15px;
            margin-bottom: 25px;
        }

        .identity-table {
            width: 100%;
            border: none;
            border-collapse: collapse;
            cellspacing: 0;
        }

        .identity-table td {
            padding: 2px 4px;
            vertical-align: top;
            border: none;
        }

        .label {
            font-weight: bold;
            color: #000;
            width: 130px;
            font-family: DejaVu Sans; 
            direction: rtl;
            text-align: right;
        }

        .separator {
            width: 2px;
            text-align: center;
            padding: 0;
        }

        .value {
            font-weight: 500;
            color: #000;
            text-align: right;
        }

        /* Section Titles */
        .section-header {
            color: #080808ff;
            padding: 8px 15px;
            font-size: 16pt;
            font-weight: bold;
            border-radius: 20px 0 20px 0;
            margin-bottom: 15px;
            display: inline-block;
            white-space: nowrap;
            text-align: right;
            direction: rtl;
        }

        /* Data Tables */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            border: 4px double #000;
            background-color: #fff;
        }

        .data-table th {
            background-color: #fff;
            color: #000;
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
            background-color: #fff;
            color: #000;
        }

        .center { text-align: center; }
        .right { text-align: right; }
        .bold { font-weight: bold; }

        /* Grades Specifics */
        .grade-score {
            font-weight: bold;
            color: #000;
        }

        /* Predikat Colors */
        .predikat-ممتاز { color: #000; font-weight: bold; }
        .predikat-جيد { color: #000; }
        .predikat-مقبول { color: #000; }
        .predikat-ضعيف { color: #000; font-weight: bold; }

        /* Notes */
        .notes {
            border: 2px dashed #000;
            padding: 15px;
            border-radius: 10px;
            background-color: #fff;
            min-height: 60px;
            direction: rtl;
        }

        /* Footer */
        .footer-table {
            width: 100%;
            margin-top: 40px;
            page-break-inside: avoid;
        }
        
        .sign-col {
            width: 33%;
            text-align: center;
            vertical-align: top;
        }
        
        .date-line {
            text-align: right;
            margin-bottom: 10px;
            color: #000;
            font-style: italic;
            padding-right: 20px;
            text-decoration: underline;
            display: inline-block;
            float: right;
        }
        
        .sign-role {
            font-size: 10pt;
            color: #000;
        }

        .sign-spacer {
            height: 300px;
        }
        
        .sign-name {
            font-weight: bold;
            font-size: 13pt;
            text-decoration: underline;
            color: #000;
        }

        .text-right {
            text-align: right;
            font-family: DejaVu Sans;
            direction: rtl;
        }
    </style>
</head>
<body>

@php
    // Function to convert Latin numerals to Eastern Arabic numerals
    if (!function_exists('toArabicNumerals')) {
        function toArabicNumerals($number) {
            $latinNumerals = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
            $arabicNumerals = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
            return str_replace($latinNumerals, $arabicNumerals, $number);
        }
    }
@endphp

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
                    <h1 class="header-title">كشف الدرجات</h1>
                    <h2 class="header-subtitle">لطلبة معهد شفاعة الرسول الإسلامي</h2>
                </div>
            </td>
        </tr>
    </table>

    <!-- Identity -->
    <div class="identity-box">
        <table class="identity-table">
            <tr>
                <td style="font-size:12px; font-family: DejaVu Sans; text-align: right;">
                    @php
                        if (!function_exists('toArabicNumerals')) {
                            function toArabicNumerals($number) {
                                $latinNumerals = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
                                $arabicNumerals = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
                                return str_replace($latinNumerals, $arabicNumerals, $number);
                            }
                        }
                        $tahunAjaran = $semester->tahunAjaran->tahun ?? '-';
                    @endphp
                    {{ toArabicNumerals($tahunAjaran) }}
                </td>
                <td class="separator">:</td>
                <td class="label">العام الدراسي</td>
                <td style="font-size:12px; font-family: DejaVu Sans; text-align: right;">{{ strtoupper($siswa->nama_arabic) }}</td>
                <td class="separator">:</td>
                <td class="label">اسم الطالبة</td>
            </tr>
            <tr>
                <td class="value" style="text-align: right;">
                    @php
                        $semesterNama = $semester->nama ?? '';
                        $semesterArabic = '-';
                        
                        if (stripos($semesterNama, 'ganjil') !== false || stripos($semesterNama, '1') !== false) {
                            $semesterArabic = 'الأول';
                        } elseif (stripos($semesterNama, 'genap') !== false || stripos($semesterNama, '2') !== false) {
                            $semesterArabic = 'الثاني';
                        }
                    @endphp
                    {{ $semesterArabic }}
                </td>
                <td class="separator">:</td>
                <td class="label">الدور</td>
                <td class="value" style="text-align: right;">{{ $kelas->nama ?? '-' }}</td>
                <td class="separator">:</td>
                <td class="label">الفصل</td>
            </tr>
        </table>
    </div>

    <!-- Academic Scores -->
    <div class="section-header">تحقيق الكفاءات والتحصيل الأكاديمي</div>
    
    @if(count($nilais) > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th width="25%" style="font-size:20px; font-family: DejaVu Sans; direction: rtl;">تقديرا</th>
                    <th width="20%" style="font-size:20px; font-family: DejaVu Sans; direction: rtl;">رقما</th>
                    <th width="50%" style="font-size:20px; font-family: DejaVu Sans; direction: rtl;">المواد الدراسية</th>
                    <th width="5%" style="font-size:20px; font-family: DejaVu Sans; direction: rtl;">النمرة</th>
                </tr>
            </thead>
            <tbody>
                @foreach($nilais as $nilaiIndex => $nilai)
                    @php
                        $nilaiPengetahuan = $nilai->nilai_pengetahuan ?? 0;
                        $isEmptyNilai = empty($nilaiPengetahuan) || $nilaiPengetahuan == 0;
                        
                        $predikat = $isEmptyNilai ? '-' : match(true) {
                            $nilaiPengetahuan >= 90 => 'ممتاز',
                            $nilaiPengetahuan >= 85 => 'جيد جدًا',
                            $nilaiPengetahuan >= 75 => 'جيد',
                            $nilaiPengetahuan >= 70 => 'مقبول',
                            default => 'ضعيف',
                        };
                        
                        $predClass = $isEmptyNilai ? '' : 'predikat-' . $predikat;
                    @endphp
                    
                    <tr>
                        <td class="center {{ $predClass }}">{{ $predikat }}</td>
                        <td class="center grade-score">{{ $isEmptyNilai ? '-' : toArabicNumerals($nilaiPengetahuan) }}</td>
                        <td class="text-right">{{ $nilai->mataPelajaran->namapelajaran_arabic ?? '-' }}</td>
                        <td class="center">{{ toArabicNumerals($nilaiIndex + 1) }}</td>
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
                
                <!-- Total Row -->
                <tr style="background-color: #fff; font-weight: bold; border: 1px solid #000;">
                    <td class="center grade-score" style="font-size:14px; padding: 8px; color: #000;">
                        {{ $totalNilai > 0 ? toArabicNumerals($totalNilai) : '-' }}
                    </td>
                    <td colspan="2" class="center" style="font-size:16px; font-family: DejaVu Sans; direction: rtl; padding: 8px; color: #000;">
                        المجموع
                    </td>
                    <td></td>
                </tr>
                
                <!-- Average Row -->
                <tr style="background-color: #fff; font-weight: bold; border: 1px solid #000;">
                    <td class="center grade-score" style="font-size:14px; padding: 8px; color: #000;">
                        {{ $average > 0 ? toArabicNumerals(number_format($average, 2)) : '-' }}
                    </td>
                    <td colspan="2" class="center" style="font-size:16px; font-family: DejaVu Sans; direction: rtl; padding: 8px; color: #000;">
                        المعدل
                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    @else
        <p class="center" style="font-style: italic; color: #777; margin: 20px;">Belum ada data nilai akademik</p>
    @endif

    <!-- Notes -->
    <div class="section-header">الملاحظات</div>
    <div class="notes">
        @if($catatan && $catatan->catatan)
            {{ $catatan->catatan }}
        @else
            <span style="color: #999; font-style: italic; font-family: DejaVu Sans; direction: rtl;">واصل تحسين إنجازاتك الدراسية، واحرص على الجد في الدراسة والعبادة</span>
        @endif
    </div>

    <!-- Signatures -->
    <div class="date-line">
        <span style="font-family: DejaVu Sans; font-size: 18px; direction: rtl;">{{ $settings->tanggal_rapor ?? '٢ محرم ١٤٤٨, تلوك كوانتن' }}</span>
    </div>
    
    <table class="footer-table">
        <tr>
            <td class="sign-col">
                <div class="sign-role">رئيسة المدرسة</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                @php
                    $tingkat = $kelas->tingkat ?? null;
                    $kepalaMadrasah = $settings->kepala_sekolah_ma ?? 'Dina Yulesti, M.Pd';
                    
                    if (in_array($tingkat, [7, 8, 9, '7', '8', '9', 'VII', 'VIII', 'IX'])) {
                        $kepalaMadrasah = $settings->kepala_sekolah_mts ?? 'S.Pd مارديه روسنيله نينغسيه';
                    }
                @endphp
                <div class="sign-name">{{ $kepalaMadrasah }}</div>
            </td>
            <td class="sign-col">
                <div class="sign-role">ولية الفصل</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-name">
                    {{ $kelas->waliKelas->nama_arabic ?? $kelas->waliKelas->nama ?? '' }}
                </div>
            </td>
            <td class="sign-col">
                <div class="sign-role">ولي الامر</div>  
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-spacer">&nbsp;</div>
                <div class="sign-name"></div>
            </td>
        </tr>
    </table>

    <!-- Student Name in Latin (Bottom Left) -->
    <div style="margin-top: 20px; font-size: 9pt; color: #666;">
        <strong>Nama Siswa:</strong> {{ $siswa->nama }}
    </div>

    @if($index < count($allRaporData) - 1)
        <div class="page-break"></div>
    @endif
@endforeach

</body>
</html>
