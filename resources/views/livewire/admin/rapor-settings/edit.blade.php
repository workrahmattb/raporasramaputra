<div>
    <!-- Header -->
    <div class="mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Pengaturan Rapor</h1>
            <p class="text-gray-600 mt-1">Kelola tanggal dan nama kepala sekolah untuk rapor</p>
        </div>
    </div>

    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <form wire:submit="save">
            <!-- Tanggal Rapor -->
            <div class="mb-6">
                <label for="tanggal_rapor" class="block text-sm font-medium text-gray-700 mb-2">
                    Tanggal Rapor <span class="text-red-500">*</span>
                </label>
                <input wire:model="tanggal_rapor" type="text" id="tanggal_rapor" 
                    placeholder="Contoh: Teluk Kuantan, 15 Januari 2026"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('tanggal_rapor') border-red-500 @enderror">
                <p class="mt-1 text-sm text-gray-500">Format bebas, contoh: Teluk Kuantan, 15 Januari 2026</p>
                @error('tanggal_rapor')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kepala Pengasuhan Asrama -->
            <div class="mb-6">
                <label for="kepala_pengasuhan_asrama" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Kepala Pengasuhan Asrama <span class="text-red-500">*</span>
                </label>
                <input wire:model="kepala_pengasuhan_asrama" type="text" id="kepala_pengasuhan_asrama" 
                    placeholder="Contoh: Mardiah Resnilawati Ningsih, S.Pd"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('kepala_pengasuhan_asrama') border-red-500 @enderror">
                <p class="mt-1 text-sm text-gray-500">Nama kepala pengasuhan asrama yang tertera di rapor</p>
                @error('kepala_pengasuhan_asrama')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Pimpinan Pondok Pesantren -->
            <div class="mb-6">
                <label for="pimpinan_pondok" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Pimpinan Pondok Pesantren <span class="text-red-500">*</span>
                </label>
                <input wire:model="pimpinan_pondok" type="text" id="pimpinan_pondok" 
                    placeholder="Contoh: Dina Yulesti, M.Pd"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('pimpinan_pondok') border-red-500 @enderror">
                <p class="mt-1 text-sm text-gray-500">Nama pimpinan pondok pesantren yang tertera di rapor</p>
                @error('pimpinan_pondok')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="flex justify-end pt-6 border-t border-gray-200">
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>
