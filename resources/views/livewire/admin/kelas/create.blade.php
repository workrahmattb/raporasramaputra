<div>
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center mb-4">
            <a href="{{ route('admin.kelas.index') }}" wire:navigate class="text-gray-600 hover:text-gray-900 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Tambah Asrama</h1>
                <p class="text-gray-600 mt-1">Buat asrama baru</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <form wire:submit="save">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tahun Ajaran -->
                <div>
                    <label for="tahun_ajaran_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Tahun Ajaran <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="tahun_ajaran_id" id="tahun_ajaran_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('tahun_ajaran_id') border-red-500 @enderror">
                        <option value="">Pilih Tahun Ajaran</option>
                        @foreach($tahunAjarans as $ta)
                            <option value="{{ $ta->id }}">{{ $ta->tahun }}</option>
                        @endforeach
                    </select>
                    @error('tahun_ajaran_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Wali Asrama -->
                <div>
                    <label for="wali_kelas_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Wali Asrama
                    </label>
                    <select wire:model="wali_kelas_id" id="wali_kelas_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('wali_kelas_id') border-red-500 @enderror">
                        <option value="">Pilih Wali Asrama (Opsional)</option>
                        @foreach($waliKelas as $wk)
                            <option value="{{ $wk->id }}">{{ $wk->nama }}</option>
                        @endforeach
                    </select>
                    @error('wali_kelas_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Asrama -->
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Asrama <span class="text-red-500">*</span>
                    </label>
                    <input wire:model="nama" type="text" id="nama" placeholder="Contoh: A, B, IPA 1, IPS 2"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nama') border-red-500 @enderror">
                    @error('nama')
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
                        <option value="">Pilih Tingkat</option>
                        <option value="1">Asrama 1</option>
                        <option value="2">Asrama 2</option>
                        <option value="3">Asrama 3</option>
                        <option value="4">Asrama 4</option>
                        <option value="5">Asrama 5</option>
                        <option value="6">Asrama 6</option>
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
                </div>

            </div>

            <!-- Actions -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 mt-6">
                <a href="{{ route('admin.kelas.index') }}" wire:navigate class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
