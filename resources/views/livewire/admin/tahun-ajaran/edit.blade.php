<div>
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center mb-4">
            <a href="{{ route('admin.tahun-ajaran.index') }}" wire:navigate class="text-gray-600 hover:text-gray-900 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Edit Tahun Ajaran</h1>
                <p class="text-gray-600 mt-1">Perbarui data tahun ajaran</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <form wire:submit="update">
            <!-- Tahun Ajaran -->
            <div class="mb-6">
                <label for="tahun" class="block text-sm font-medium text-gray-700 mb-2">
                    Tahun Ajaran <span class="text-red-500">*</span>
                </label>
                <input wire:model="tahun" type="text" id="tahun" placeholder="Contoh: 2024/2025"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('tahun') border-red-500 @enderror">
                @error('tahun')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal Mulai -->
            <div class="mb-6">
                <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-2">
                    Tanggal Mulai <span class="text-red-500">*</span>
                </label>
                <input wire:model="tanggal_mulai" type="date" id="tanggal_mulai"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('tanggal_mulai') border-red-500 @enderror">
                @error('tanggal_mulai')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal Selesai -->
            <div class="mb-6">
                <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700 mb-2">
                    Tanggal Selesai <span class="text-red-500">*</span>
                </label>
                <input wire:model="tanggal_selesai" type="date" id="tanggal_selesai"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('tanggal_selesai') border-red-500 @enderror">
                @error('tanggal_selesai')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.tahun-ajaran.index') }}" wire:navigate class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                    Perbarui
                </button>
            </div>
        </form>
    </div>
</div>
