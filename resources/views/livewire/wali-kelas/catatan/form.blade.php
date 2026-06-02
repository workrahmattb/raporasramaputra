<div>
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center mb-4">
            <a href="{{ route('wali-kelas.catatan.index') }}" wire:navigate class="text-gray-600 hover:text-gray-900 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Input Catatan Wali Asrama</h1>
                <p class="text-gray-600 mt-1">{{ $siswa->nama }} - {{ $kelas->nama ?? '' }}</p>
            </div>
        </div>
    </div>

    <!-- Info Card -->
    <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-blue-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div class="text-sm text-blue-800">
                <p class="font-semibold">Semester: {{ $semester->nama ?? 'Belum ada semester aktif' }}</p>
                <p class="mt-1">Berikan catatan mengenai perkembangan dan perilaku siswa selama semester ini.</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <form wire:submit="save">
        <div class="bg-white rounded-lg shadow-md p-6">
            <!-- Student Info -->
            <div class="mb-6 pb-6 border-b border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">NISN</label>
                        <p class="mt-1 text-gray-900">{{ $siswa->nisn }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <p class="mt-1 text-gray-900 font-semibold">{{ $siswa->nama }}</p>
                    </div>
                </div>
            </div>

            <!-- Catatan Input -->
            <div class="mb-6">
                <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">
                    Catatan Wali Asrama
                    <span class="text-red-500">*</span>
                </label>
                <textarea wire:model.live="catatan" 
                          id="catatan"
                          rows="6" 
                          placeholder="Tuliskan catatan mengenai perkembangan akademik, sikap, dan perilaku siswa..."
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('catatan') border-red-500 @enderror"></textarea>
                
                <div class="flex justify-between items-center mt-2">
                    @error('catatan')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @else
                        <p class="text-sm text-gray-500">Catatan akan ditampilkan pada rapor siswa</p>
                    @enderror
                    <p class="text-sm {{ $this->characterCount > 1000 ? 'text-red-600' : 'text-gray-500' }}">
                        {{ $this->characterCount }} / 1000 karakter
                    </p>
                </div>
            </div>

            <!-- Preview -->
            @if($catatan)
                <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-xs font-medium text-gray-500 uppercase mb-2">Preview Catatan:</p>
                    <p class="text-sm text-gray-700">{{ $catatan }}</p>
                </div>
            @endif

            <!-- Actions -->
            <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                <a href="{{ route('wali-kelas.catatan.index') }}" wire:navigate class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                    </svg>
                    Simpan Catatan
                </button>
            </div>
        </div>
    </form>
</div>
