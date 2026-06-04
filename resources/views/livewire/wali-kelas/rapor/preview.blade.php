<div>
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('wali-kelas.rapor.index') }}" wire:navigate class="text-gray-600 hover:text-gray-900 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Preview Rapor</h1>
                    <p class="text-gray-600 mt-1">{{ $siswa->nama }} - {{ $semester->nama ?? '' }}</p>
                </div>
            </div>
            <div>
                <a href="{{ route('wali-kelas.rapor.print', ['siswaId' => $siswaId, 'semesterId' => $semesterId]) }}" 
                   target="_blank"
                   class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Cetak PDF
                </a>
            </div>
        </div>
    </div>

    <!-- Rapor Preview -->
    <div class="bg-white rounded-lg shadow-md p-8">
        <!-- Student Identity -->
        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4 border-b-2 border-blue-600 pb-2">Identitas Siswa</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Nama</p>
                    <p class="font-semibold">{{ $siswa->nama }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">NISN</p>
                    <p class="font-semibold">{{ $siswa->nisn }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Asrama</p>
                    <p class="font-semibold">{{ $kelas->nama ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Semester</p>
                    <p class="font-semibold">{{ $semester->nama ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Academic Scores -->
        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4 border-b-2 border-blue-600 pb-2">Nilai Akademik</h2>
            @if(count($nilais) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aspek Penilaian<br><span style="font-weight:normal;font-size:10px">(Assessment Aspect)</span></th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Pengetahuan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($nilais as $index => $nilai)
                                <tr>
                                    <td class="px-4 py-3 text-sm">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $nilai->mataPelajaran->nama ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm text-center font-semibold">{{ $nilai->nilai_pengetahuan ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Belum ada nilai</p>
            @endif
        </div>

        <!-- Attendance -->
        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4 border-b-2 border-blue-600 pb-2">Kehadiran</h2>
            @if($kehadiran)
                <div class="grid grid-cols-4 gap-4">
                    <div class="bg-yellow-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Sakit</p>
                        <p class="text-2xl font-bold text-yellow-600">{{ $kehadiran->sakit ?? 0 }}</p>
                    </div>
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Izin</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $kehadiran->izin ?? 0 }}</p>
                    </div>
                    <div class="bg-red-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Tanpa Keterangan</p>
                        <p class="text-2xl font-bold text-red-600">{{ $kehadiran->tanpa_keterangan ?? 0 }}</p>
                    </div>
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Belum ada data kehadiran</p>
            @endif
        </div>

        <!-- Teacher Notes -->
        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4 border-b-2 border-blue-600 pb-2">Catatan Wali Asrama</h2>
            @if($catatan && $catatan->catatan)
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-700">{{ $catatan->catatan }}</p>
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Belum ada catatan</p>
            @endif
        </div>
    </div>
</div>
