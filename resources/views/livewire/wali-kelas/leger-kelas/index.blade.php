<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Leger Asrama</h1>
            <p class="mt-2 text-sm text-gray-600">
                Daftar nilai seluruh siswa dengan rata-rata dan ranking
            </p>
        </div>

        @if(session()->has('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if($kelas)
            <!-- Class Info & Controls -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Class Info -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-2">Informasi Asrama</h2>
                        <div class="space-y-1 text-sm">
                            <p><span class="font-medium text-gray-700">Asrama:</span> {{ $kelas->nama }}</p>
                            <p><span class="font-medium text-gray-700">Tahun Ajaran:</span> {{ $kelas->tahunAjaran->tahun ?? '-' }}</p>
                            <p><span class="font-medium text-gray-700">Wali Asrama:</span> {{ $kelas->waliKelas->nama ?? '-' }}</p>
                        </div>
                    </div>

                    <!-- Semester Selection -->
                    <div>
                        <label for="semester" class="block text-sm font-medium text-gray-700 mb-2">
                            Pilih Semester
                        </label>
                        <select wire:model.live="semesterId" id="semester" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Pilih Semester --</option>
                            @foreach($semesters as $sem)
                                <option value="{{ $sem->id }}">{{ $sem->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Export Button -->
                @if(count($legerData) > 0)
                    <div class="mt-6 flex justify-end">
                        <button wire:click="export" 
                                class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition shadow-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Export ke Excel
                        </button>
                    </div>
                @endif
            </div>

            <!-- Leger Table -->
            @if(count($legerData) > 0)
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-blue-600">
                                <tr>
                                    <th scope="col" class="sticky left-0 z-10 bg-blue-600 px-4 py-3 text-center text-xs font-bold text-white uppercase tracking-wider border-r border-blue-500">
                                        No
                                    </th>
                                    <th scope="col" class="sticky left-12 z-10 bg-blue-600 px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider border-r border-blue-500">
                                        Nama Siswa
                                    </th>
                                    @foreach($mataPelajarans as $mapel)
                                        <th scope="col" class="px-4 py-3 text-center text-xs font-bold text-white uppercase tracking-wider border-r border-blue-500 whitespace-nowrap">
                                            {{ $mapel->nama }}
                                        </th>
                                    @endforeach
                                    <th scope="col" class="px-4 py-3 text-center text-xs font-bold text-white uppercase tracking-wider border-r border-blue-500 bg-blue-700">
                                        Jumlah
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-center text-xs font-bold text-white uppercase tracking-wider border-r border-blue-500 bg-blue-700">
                                        Rata-rata
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-center text-xs font-bold text-white uppercase tracking-wider bg-blue-700">
                                        Ranking
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($legerData as $index => $siswa)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="sticky left-0 z-10 bg-white px-4 py-4 text-center text-sm font-medium text-gray-900 border-r border-gray-200">
                                            {{ $index + 1 }}
                                        </td>
                                        <td class="sticky left-12 z-10 bg-white px-6 py-4 text-sm text-gray-900 border-r border-gray-200">
                                            {{ $siswa['nama'] }}
                                        </td>
                                        @foreach($mataPelajarans as $mapel)
                                            @php
                                                $nilai = $siswa['grades'][$mapel->id] ?? null;
                                                $displayNilai = ($nilai !== null && $nilai > 0) ? $nilai : '-';
                                            @endphp
                                            <td class="px-4 py-4 text-center text-sm text-gray-900 border-r border-gray-200">
                                                {{ $displayNilai }}
                                            </td>
                                        @endforeach
                                        <td class="px-4 py-4 text-center text-sm font-semibold text-purple-600 border-r border-gray-200 bg-purple-50">
                                            {{ $siswa['total'] > 0 ? $siswa['total'] : '-' }}
                                        </td>
                                        <td class="px-4 py-4 text-center text-sm font-semibold text-blue-600 border-r border-gray-200 bg-blue-50">
                                            {{ $siswa['average'] > 0 ? number_format($siswa['average'], 2) : '-' }}
                                        </td>
                                        <td class="px-4 py-4 text-center text-sm font-bold text-green-600 bg-green-50">
                                            {{ $siswa['ranking'] }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @elseif($semesterId)
                <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada data</h3>
                    <p class="mt-1 text-sm text-gray-500">Belum ada data nilai untuk semester ini.</p>
                </div>
            @else
                <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Pilih Semester</h3>
                    <p class="mt-1 text-sm text-gray-500">Silakan pilih semester untuk melihat leger asrama.</p>
                </div>
            @endif
        @endif
    </div>
</div>
