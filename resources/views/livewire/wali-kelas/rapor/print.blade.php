<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Rapor - {{ $siswa->nama }}</title>
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
            color: #020302ff; /* Green Text */
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
            color: #030303ff; /* Yellow/Gold Accent */
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
            /* background-color: #006025; */
            color: #080808ff;
            padding: 8px 15px;
            font-size: 16pt;
            font-weight: bold;
            border-radius: 20px 0 20px 0; /* Futuristic shape */
            margin-bottom: 15px;
            display: inline-block;
            white-space: nowrap;
            /* box-shadow: 2px 2px 0px #dcb000; Yellow shadow */
            text-align: right;
            direction: rtl;
        }

        /* Data Tables */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            /* Double border effect - outer thick border */
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

        .data-table tr:nth-child(even) td {
            background-color: #fff; /* Remove striped rows, keep white */
        }

        .center { text-align: center; }
        .right { text-align: right; }
        .bold { font-weight: bold; }

        /* Grades Specifics */
        .grade-score {
            font-weight: bold;
            color: #000;
        }

        /* Predikat Colors - all black now */
        .predikat-ممتاز { color: #000; font-weight: bold; }
        .predikat-جيد { color: #000; }
        .predikat-جيد { color: #000; }
        .predikat-مقبول { color: #000; }
        .predikat-ضعيف { color: #000; font-weight: bold; }

        /* Attendance Box */
        .attendance-container {
            width: 100%;
            margin-bottom: 20px;
        }

        .attendance-box {
            display: inline-block;
            width: 30%;
            text-align: center;
            border: 1px solid #ddd;
            padding: 10px;
            margin-right: 2%;
            background: #fff;
        }
        
        .attendance-box.sakit { border-top: 3px solid #000; }
        .attendance-box.izin { border-top: 3px solid #000; }
        .attendance-box.alpha { border-top: 3px solid #000; }

        .att-label { font-size: 9pt; color: #000; margin-bottom: 5px; }
        .att-value { font-size: 14pt; font-weight: bold; color: #000; }

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
                    <!-- <p class="header-address">Teluk Kuantan, Kabupaten Kuantan Singingi, Riau</p>
                    <p class="header-address">Website: www.syafaaturrasul.com | Email: info@syafaaturrasul.com</p> -->
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
                    <th width="25%"
                        style="font-size:20px; font-family: DejaVu Sans; direction: rtl;">
                        تقديرا
                    </th>
                    <th width="20%"
                        style="font-size:20px; font-family: DejaVu Sans; direction: rtl;">
                        رقما
                    </th>
                    <th width="50%"
                        style="font-size:20px; font-family: DejaVu Sans; direction: rtl;">
                        المواد الدراسية
                    </th>
                    <th width="5%"
                        style="font-size:20px; font-family: DejaVu Sans; direction: rtl;">
                        النمرة
                    </th>
                </tr>

            </thead>
            <tbody>
                @foreach($nilais as $index => $nilai)
                    @php
                        // Get nilai_pengetahuan, treat null and empty as 0
                        $nilaiPengetahuan = $nilai->nilai_pengetahuan ?? 0;
                        
                        // Check if nilai is empty, null, or 0
                        $isEmptyNilai = empty($nilaiPengetahuan) || $nilaiPengetahuan == 0;
                        
                        // Only calculate predikat if nilai is not empty
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
                        <td class="center {{ $predClass }}">
                            {{ $predikat }}
                        </td>
                        <td class="center grade-score">{{ $isEmptyNilai ? '-' : toArabicNumerals($nilaiPengetahuan) }}</td>
                        <td class="text-right">{{ $nilai->mataPelajaran->namapelajaran_arabic ?? '-' }}</td>
                        <td class="center">{{ toArabicNumerals($index + 1) }}</td>
                    </tr>
                @endforeach
                
                @php
                    // Calculate total and average
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

    <!-- Attendance
    <div class="section-header">B. KETIDAKHADIRAN</div>
    
    
    <table width="100%" style="margin-bottom: 20px;">
        <tr>
            <td width="33%" style="padding-right: 10px;">
                <div style="border: 1px solid #ddd; border-top: 3px solid #3498db; padding: 10px; text-align: center; background: #fff;">
                    <div class="att-label">SAKIT</div>
                    <div class="att-value">{{ $kehadiran->sakit ?? 0 }}</div>
                    <div style="font-size: 8pt; color: #999;">Hari</div>
                </div>
            </td>
            <td width="33%" style="padding: 0 5px;">
                <div style="border: 1px solid #ddd; border-top: 3px solid #f1c40f; padding: 10px; text-align: center; background: #fff;">
                    <div class="att-label">IZIN</div>
                    <div class="att-value">{{ $kehadiran->izin ?? 0 }}</div>
                    <div style="font-size: 8pt; color: #999;">Hari</div>
                </div>
            </td>
            <td width="33%" style="padding-left: 10px;">
                <div style="border: 1px solid #ddd; border-top: 3px solid #e74c3c; padding: 10px; text-align: center; background: #fff;">
                    <div class="att-label">ALPHA</div>
                    <div class="att-value">{{ $kehadiran->alpha ?? 0 }}</div>
                    <div style="font-size: 8pt; color: #999;">Hari</div>
                </div>
            </td>
        </tr>
    </table> -->

    <!-- Notes -->
    <div class="section-header">الملاحظات</div>
    <div class="notes">
        @if($catatan && $catatan->catatan)
            {{ $catatan->catatan }}
        @else
            <span style="color: #999; font-style: italic; font-family: DejaVu Sans; direction: rtl;">واصل تحسين إنجازاتك الدراسية، واحرص على الجد في الدراسة والعبادة</span>
        @endif
    </div>

    <!-- Signatures Tulis Tanggal Cetak Rapornya disini -->
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

</body>
</html>
