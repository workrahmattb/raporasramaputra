<div>
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center mb-4">
            <a href="{{ route('admin.mata-pelajaran.index') }}" wire:navigate class="text-gray-600 hover:text-gray-900 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Tambah Mata Pelajaran</h1>
                <p class="text-gray-600 mt-1">Tambahkan mata pelajaran baru</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <form wire:submit="save">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kode -->
                <div>
                    <label for="kode" class="block text-sm font-medium text-gray-700 mb-2">
                        Kode Mata Pelajaran <span class="text-red-500">*</span>
                    </label>
                    <input wire:model="kode" type="text" id="kode" placeholder="Contoh: MTK"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('kode') border-red-500 @enderror">
                    @error('kode')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama -->
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Mata Pelajaran <span class="text-red-500">*</span>
                    </label>
                    <input wire:model="nama" type="text" id="nama" placeholder="Contoh: Matematika"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nama') border-red-500 @enderror">
                    @error('nama')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Pelajaran Arabic -->
                <div>
                    <label for="namapelajaran_arabic" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Pelajaran Arabic
                    </label>
                    <input wire:model="namapelajaran_arabic" type="text" id="namapelajaran_arabic" placeholder="Nama mata pelajaran dalam bahasa Arab"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('namapelajaran_arabic') border-red-500 @enderror">
                    @error('namapelajaran_arabic')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kelompok -->
                <div>
                    <label for="kelompok" class="block text-sm font-medium text-gray-700 mb-2">
                        Kelompok <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="kelompok" id="kelompok"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('kelompok') border-red-500 @enderror">
                        <option value="A">Kelompok A - Umum</option>
                        <option value="B">Kelompok B - Agama</option>
                        <option value="C">Kelompok C - Muatan Lokal</option>
                    </select>
                    @error('kelompok')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">
                        A: Matematika, IPA, IPS, dll | B: Al-Quran, Hadits, Fiqih, dll | C: Bahasa Daerah, Keterampilan, dll
                    </p>
                </div>

                <!-- Tingkat -->
                <div>
                    <label for="tingkat" class="block text-sm font-medium text-gray-700 mb-2">
                        Tingkat/Asrama
                    </label>
                    <select wire:model="tingkat" id="tingkat"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('tingkat') border-red-500 @enderror">
                        <option value="">Pilih Tingkat (Opsional)</option>
                        <option value="7">Asrama 7</option>
                        <option value="8">Asrama 8</option>
                        <option value="9">Asrama 9</option>
                        <option value="10">Asrama 10</option>
                        <option value="11">Asrama 11</option>
                        <option value="12">Asrama 12</option>
                    </select>
                    @error('tingkat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Pilih tingkat asrama untuk mata pelajaran ini</p>
                </div>

                <!-- KKM -->
                <div>
                    <label for="kkm" class="block text-sm font-medium text-gray-700 mb-2">
                        KKM (Kriteria Ketuntasan Minimal) <span class="text-red-500">*</span>
                    </label>
                    <input wire:model="kkm" type="number" id="kkm" min="0" max="100" placeholder="75"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('kkm') border-red-500 @enderror">
                    @error('kkm')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Nilai minimal untuk dinyatakan tuntas (0-100)</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 mt-6">
                <a href="{{ route('admin.mata-pelajaran.index') }}" wire:navigate class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
