<div>
    <!-- Header -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Kelola Mata Pelajaran</h1>
            <p class="text-gray-600 mt-1">Manajemen mata pelajaran dan KKM</p>
        </div>
        <a href="{{ route('admin.mata-pelajaran.create') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Mata Pelajaran
        </a>
    </div>

    <!-- Flash Message -->
    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('message') }}
        </div>
    @endif

    <!-- Search & Filter -->
    <div class="mb-6 bg-white rounded-lg shadow-md p-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Search -->
            <div class="relative">
                <input wire:model.live="search" type="text" placeholder="Cari kode atau nama mata pelajaran..." 
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            
            <!-- Filter Kelompok -->
            <div>
                <select wire:model.live="kelompok" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Kelompok</option>
                    <option value="A">Kelompok A - Umum</option>
                    <option value="B">Kelompok B - Agama</option>
                    <option value="C">Kelompok C - Muatan Lokal</option>
                </select>
            </div>

            <!-- Filter Tingkat -->
            <div>
                <select wire:model.live="tingkat" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Tingkat</option>
                    <option value="7">Asrama 7</option>
                    <option value="8">Asrama 8</option>
                    <option value="9">Asrama 9</option>
                    <option value="10">Asrama 10</option>
                    <option value="11">Asrama 11</option>
                    <option value="12">Asrama 12</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow-md overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Mata Pelajaran</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Arabic</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelompok</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tingkat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">KKM</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($mataPelajarans as $mataPelajaran)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $mataPelajaran->kode }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $mataPelajaran->nama }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @if(isset($editingNamaArabic[$mataPelajaran->id]) && $editingNamaArabic[$mataPelajaran->id])
                                <div class="flex items-center gap-2">
                                    <input 
                                        wire:model="namaArabicValues.{{ $mataPelajaran->id }}" 
                                        type="text" 
                                        dir="rtl"
                                        class="flex-1 px-2 py-1 text-sm border border-blue-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="Nama dalam bahasa Arab"
                                    >
                                    <button 
                                        wire:click="updateNamaArabic({{ $mataPelajaran->id }})"
                                        class="p-1 text-green-600 hover:text-green-800"
                                        title="Simpan"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </button>
                                    <button 
                                        wire:click="cancelEditNamaArabic({{ $mataPelajaran->id }})"
                                        class="p-1 text-red-600 hover:text-red-800"
                                        title="Batal"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            @else
                                <div class="flex items-center gap-2 group">
                                    <div class="text-sm text-gray-600 flex-1" dir="rtl">
                                        {{ $mataPelajaran->namapelajaran_arabic ?? '-' }}
                                    </div>
                                    <button 
                                        wire:click="editNamaArabic({{ $mataPelajaran->id }})"
                                        class="opacity-0 group-hover:opacity-100 p-1 text-blue-600 hover:text-blue-800 transition-opacity"
                                        title="Edit Nama Arabic"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                        </svg>
                                    </button>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $mataPelajaran->kelompok === 'A' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $mataPelajaran->kelompok === 'B' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $mataPelajaran->kelompok === 'C' ? 'bg-purple-100 text-purple-800' : '' }}">
                                Kelompok {{ $mataPelajaran->kelompok }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($mataPelajaran->tingkat)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                    Asrama {{ $mataPelajaran->tingkat }}
                                </span>
                            @else
                                <span class="text-sm text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $mataPelajaran->kkm }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.mata-pelajaran.edit', $mataPelajaran->id) }}" wire:navigate class="text-blue-600 hover:text-blue-900 mr-3">
                                Edit
                            </a>
                            <button wire:click="confirmDelete({{ $mataPelajaran->id }})" class="text-red-600 hover:text-red-900">
                                Hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <p class="mt-2">Belum ada data mata pelajaran</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $mataPelajarans->links() }}
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    @if($confirmingDeletion)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Konfirmasi Hapus</h3>
                <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus mata pelajaran ini? Data nilai terkait juga akan terhapus.</p>
                <div class="flex justify-end space-x-3">
                    <button wire:click="$set('confirmingDeletion', false)" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition">
                        Batal
                    </button>
                    <button wire:click="delete" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
