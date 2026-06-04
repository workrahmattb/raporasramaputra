<div>
    <!-- Script untuk close dropdown saat klik di luar -->
    <script>
        document.addEventListener('click', function(event) {
            const dropdownContainer = document.getElementById('searchable-dropdown-container');
            const searchInput = document.getElementById('searchSiswa');
            
            if (dropdownContainer && searchInput) {
                const isClickInside = dropdownContainer.contains(event.target);
                const isInput = searchInput.contains(event.target);
                
                if (!isClickInside && !isInput) {
                    @this.set('showDropdown', false);
                }
            }
        });
    </script>

    <!-- Add Student Form -->
    <div class="mb-6 bg-white rounded-lg shadow-md p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Tambah Siswa ke Asrama</h2>

        <form wire:submit="addSiswa">
            <div class="grid grid-cols-1 gap-4">
                <!-- Searchable Dropdown -->
                <div class="relative" id="searchable-dropdown-container">
                    <label for="searchSiswa" class="block text-sm font-medium text-gray-700 mb-2">
                        Pilih Siswa
                        <span class="text-red-500">*</span>
                    </label>
                    
                    <!-- Input Field -->
                    <div class="relative">
                        @if($selectedSiswa || $siswaId)
                            <!-- Display Selected Student -->
                            <div class="w-full px-4 py-2 bg-green-50 border border-green-300 rounded-lg text-green-900 font-medium">
                                {{ $selectedSiswa['nama'] ?? ($siswaId ? \App\Models\SiswaRapor::find($siswaId)?->nama : '') }}
                            </div>
                            <button
                                type="button"
                                wire:click="$set(['siswaId' => null, 'selectedSiswa' => null, 'searchSiswa' => ''])"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-red-600"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        @else
                            <!-- Search Input -->
                            <input
                                wire:model.live.debounce.300ms="searchSiswa"
                                wire:click="$set('showDropdown', true)"
                                type="text"
                                id="searchSiswa"
                                class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('siswaId') border-red-500 @enderror"
                                placeholder="Klik untuk lihat semua siswa atau ketik untuk mencari..."
                                autocomplete="off"
                            >
                            <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        @endif
                    </div>
                    @error('siswaId')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <!-- Dropdown dengan Search -->
                    @if($showDropdown)
                        <div class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-80 overflow-y-auto">
                            <!-- Search Box di Dalam Dropdown -->
                            <div class="sticky top-0 bg-white border-b border-gray-200 p-3">
                                <input
                                    wire:model.live.debounce.300ms="searchSiswa"
                                    type="text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="🔍 Cari siswa (nama/NISN)..."
                                    autocomplete="off"
                                >
                            </div>

                            <!-- Hasil Pencarian -->
                            @if($this->availableSiswas->count() > 0)
                                @foreach($this->availableSiswas as $siswa)
                                    <button
                                        type="button"
                                        wire:click="selectSiswa({{ $siswa->id }}, '{{ addslashes($siswa->nama) }}')"
                                        class="w-full text-left px-4 py-3 hover:bg-blue-50 transition flex items-center justify-between group border-b border-gray-100 last:border-0"
                                    >
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $siswa->nama }}</div>
                                            <div class="text-sm text-gray-500">NISN: {{ $siswa->nisn ?? '-' }}</div>
                                        </div>
                                        <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600 flex-shrink-0 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </button>
                                @endforeach

                                <!-- Pagination -->
                                @if($this->availableSiswas->hasPages())
                                    <div class="border-t border-gray-200 px-4 py-3 bg-gray-50">
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-600">
                                                Halaman {{ $this->availableSiswas->currentPage() }} dari {{ $this->availableSiswas->lastPage() }}
                                            </span>
                                            <div class="flex space-x-2">
                                                @if($this->availableSiswas->onFirstPage())
                                                    <button disabled class="px-3 py-1 text-gray-400 cursor-not-allowed text-sm">Previous</button>
                                                @else
                                                    <button
                                                        type="button"
                                                        wire:click="previousPage('searchSiswaPage')"
                                                        class="px-3 py-1 text-blue-600 hover:bg-blue-100 rounded text-sm"
                                                    >
                                                        Previous
                                                    </button>
                                                @endif

                                                @if($this->availableSiswas->hasMorePages())
                                                    <button
                                                        type="button"
                                                        wire:click="nextPage('searchSiswaPage')"
                                                        class="px-3 py-1 text-blue-600 hover:bg-blue-100 rounded text-sm"
                                                    >
                                                        Next
                                                    </button>
                                                @else
                                                    <button disabled class="px-3 py-1 text-gray-400 cursor-not-allowed text-sm">Next</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="px-4 py-8 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="mt-2 text-gray-700">Tidak ada siswa ditemukan</p>
                                    <p class="text-sm text-gray-500 mt-1">Coba dengan kata kunci lain</p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Siswa Terpilih -->
                @if($selectedSiswa || $siswaId)
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <span class="text-green-800 font-medium">Siswa terpilih:</span>
                                <span class="ml-2 text-green-900">{{ $selectedSiswa['nama'] ?? ($siswaId ? \App\Models\SiswaRapor::find($siswaId)?->nama : '') }}</span>
                            </div>
                        </div>
                        <button
                            type="button"
                            wire:click="$set(['siswaId' => null, 'selectedSiswa' => null])"
                            class="text-red-600 hover:text-red-900 p-1"
                            title="Batal pilih siswa ini"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                @endif
            </div>

            <div class="mt-4">
                <button
                    type="submit"
                    {{ !$siswaId ? 'disabled' : '' }}
                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white rounded-lg transition flex items-center font-medium"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Siswa
                </button>
            </div>
        </form>

        <!-- Info Box -->
        <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="text-sm text-blue-800">
                    <p class="font-semibold">Cara Menggunakan:</p>
                    <ol class="mt-1 list-decimal list-inside space-y-1">
                        <li>Klik pada kolom "Pilih Siswa" untuk membuka dropdown</li>
                        <li>Scroll untuk melihat semua siswa, atau ketik untuk mencari</li>
                        <li>Klik pada nama siswa untuk memilih</li>
                        <li>Tekan tombol "Tambah Siswa" untuk menambahkan ke asrama</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Students List -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">
                ASRAMA
                <span class="text-blue-600">{{ $kelas->nama }}</span>
                <span class="text-gray-500 font-normal ml-2">({{ $siswasDiKelas->total() }} siswa)</span>
            </h2>
        </div>

        @if(count($siswasDiKelas) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NISN</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Kelamin</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($siswasDiKelas as $index => $siswa)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $siswasDiKelas->firstItem() + $index }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $siswa->nisn }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $siswa->nama }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-3">
                                        <a href="{{ route('admin.siswa.view', $siswa->id) }}" wire:navigate class="text-blue-600 hover:text-blue-900 inline-flex items-center">
                                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            View
                                        </a>
                                        <button wire:click="confirmDelete({{ $siswa->id }})" class="text-red-600 hover:text-red-900 inline-flex items-center">
                                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($siswasDiKelas->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $siswasDiKelas->links() }}
                </div>
            @endif
        @else
            <div class="px-6 py-12 text-center text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <p class="mt-2">Belum ada siswa di asrama ini</p>
                <p class="text-sm text-gray-400 mt-1">Tambahkan siswa menggunakan form di atas</p>
            </div>
        @endif
    </div>

    <!-- Delete Confirmation Modal -->
    @if($confirmingDeletion)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Konfirmasi Hapus</h3>
                <p class="text-gray-600 mb-6">Apakah Anda yakin ingin mengeluarkan siswa ini dari kelas?</p>
                
                <div class="flex justify-end space-x-3">
                    <button wire:click="$set('confirmingDeletion', false)" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition">
                        Batal
                    </button>
                    <button wire:click="deleteSiswa" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
