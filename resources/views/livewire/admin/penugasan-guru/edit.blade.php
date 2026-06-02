<div>
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center mb-4">
            <a href="{{ route('admin.penugasan-guru.index') }}" wire:navigate class="text-gray-600 hover:text-gray-900 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Edit Penugasan Guru</h1>
                <p class="text-gray-600 mt-1">Ubah penugasan guru mengajar</p>
            </div>
        </div>
    </div>

    <!-- Error Message -->
    @if (session()->has('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <!-- Active Academic Info -->
    @if($tahunAjaran || $semester)
        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <div class="flex-1">
                    <div class="flex items-center space-x-6">
                        @if($tahunAjaran)
                            <div>
                                <span class="text-sm font-medium text-gray-700">Tahun Ajaran:</span>
                                <span class="ml-2 text-sm font-bold text-green-700">{{ $tahunAjaran->tahun }}</span>
                            </div>
                        @endif
                        @if($semester)
                            <div>
                                <span class="text-sm font-medium text-gray-700">Semester:</span>
                                <span class="ml-2 text-sm font-bold text-green-700">{{ $semester->nama }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <form wire:submit="save">
            <div class="space-y-6">
                <!-- Guru -->
                <div>
                    <label for="guru" class="block text-sm font-medium text-gray-700 mb-2">
                        Guru <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="guru_id" id="guru"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('guru_id') border-red-500 @enderror">
                        <option value="">-- Pilih Guru --</option>
                        @foreach($gurus as $guru)
                            <option value="{{ $guru->id }}">{{ $guru->nama }} ({{ $guru->nip }})</option>
                        @endforeach
                    </select>
                    @error('guru_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mata Pelajaran -->
                <div>
                    <label for="mata_pelajaran" class="block text-sm font-medium text-gray-700 mb-2">
                        Mata Pelajaran <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="mata_pelajaran_id" id="mata_pelajaran"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('mata_pelajaran_id') border-red-500 @enderror">
                        <option value="">-- Pilih Mata Pelajaran --</option>
                        @foreach($mataPelajarans as $mapel)
                            <option value="{{ $mapel->id }}">{{ $mapel->kode }} - {{ $mapel->nama }}</option>
                        @endforeach
                    </select>
                    @error('mata_pelajaran_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tingkat -->
                <div>
                    <label for="tingkat" class="block text-sm font-medium text-gray-700 mb-2">
                        Tingkat <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="tingkat" id="tingkat"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('tingkat') border-red-500 @enderror">
                        <option value="">-- Pilih Tingkat --</option>
                        @foreach($tingkats as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('tingkat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Info Box -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-yellow-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="text-sm text-yellow-800">
                            <p class="font-semibold">Perhatian:</p>
                            <p class="mt-1">Perubahan penugasan guru akan mempengaruhi data nilai yang sudah diinput. Pastikan perubahan sudah benar sebelum menyimpan.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end space-x-3 mt-6 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.penugasan-guru.index') }}" wire:navigate class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
