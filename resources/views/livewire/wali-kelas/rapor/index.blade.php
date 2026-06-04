<div>
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Cetak Rapor</h1>
        <p class="text-gray-600 mt-1">Preview dan cetak rapor siswa</p>
    </div>

    <!-- Informasi Asrama -->
    @if($kelas)
        <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <div>
                    <p class="font-semibold text-gray-900">{{ $kelas->nama }}</p>
                    <p class="text-sm text-gray-600">{{ $kelas->tahunAjaran->nama ?? '' }}</p>
                </div>
            </div>
        </div>

        <!-- Semester Filter -->
        <div class="mb-6 bg-white rounded-lg shadow-md p-4">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1">
                    <label for="semester" class="block text-sm font-medium text-gray-700 mb-2">Pilih Semester</label>
                    <select wire:model.live="semesterId" id="semester" class="w-full md:w-64 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-- Pilih Semester --</option>
                        @foreach($semesters as $sem)
                            <option value="{{ $sem->id }}">{{ $sem->nama_lengkap }}</option>
                        @endforeach
                    </select>
                </div>
                @if($semesterId && count($siswas) > 0)
                    <div class="flex items-end">
                        <a href="{{ route('wali-kelas.rapor.print-all-class', ['semesterId' => $semesterId]) }}" 
                           class="inline-flex items-center px-4 py-2 bg-[#006025] text-white rounded-lg hover:bg-[#004d1c] transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            Cetak Semua
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Students Table -->
        @if($semesterId && count($siswas) > 0)
            <div class="bg-white rounded-lg shadow-md overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NISN</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/3">Catatan Wali Asrama</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($siswas as $siswa)
                            <tr class="hover:bg-gray-50" wire:key="siswa-{{ $siswa->id }}">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $siswa->nomor_absen }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $siswa->nisn }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $siswa->nama }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 relative">
                                    <textarea 
                                        wire:model.live.debounce.1000ms="catatan.{{ $siswa->id }}" 
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-[#006025] focus:ring focus:ring-[#006025] focus:ring-opacity-50 text-sm transition"
                                        rows="3"
                                        placeholder="Tulis catatan perkembangan siswa..."
                                    ></textarea>
                                    <div class="absolute bottom-2 right-8 pointer-events-none">
                                        <span wire:loading wire:target="catatan.{{ $siswa->id }}" class="text-xs text-[#006025] italic">Menyimpan...</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('wali-kelas.rapor.preview', ['siswaId' => $siswa->id, 'semesterId' => $semesterId]) }}" 
                                           wire:navigate
                                           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Preview
                                        </a>
                                        
                                        <a href="{{ route('wali-kelas.rapor.print', ['siswaId' => $siswa->id, 'semesterId' => $semesterId]) }}" 
                                           target="_blank"
                                           class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                            </svg>
                                            Cetak PDF
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @elseif($semesterId)
            <div class="bg-white rounded-lg shadow-md p-12 text-center text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <p class="mt-2">Belum ada siswa di kelas ini</p>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-12 text-center text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <p class="mt-2">Pilih semester terlebih dahulu</p>
            </div>
        @endif
    @else
        <div class="bg-white rounded-lg shadow-md p-12 text-center text-gray-500">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <p class="mt-2">Anda belum ditugaskan sebagai wali asrama</p>
            <p class="text-sm text-gray-400 mt-1">Hubungi admin untuk assign sebagai wali asrama</p>
        </div>
    @endif
</div>
