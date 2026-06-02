<div>
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center mb-4">
            <a href="{{ route('admin.siswa.index') }}" wire:navigate class="text-gray-600 hover:text-gray-900 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Edit Siswa</h1>
                <p class="text-gray-600 mt-1">Perbarui data siswa</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <form wire:submit="update">
            <!-- Data Siswa -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200">Data Siswa</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- NISN -->
                    <div>
                        <label for="nisn" class="block text-sm font-medium text-gray-700 mb-2">
                            NISN <span class="text-red-500">*</span>
                        </label>
                        <input wire:model="nisn" type="text" id="nisn" placeholder="Nomor Induk Siswa Nasional"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nisn') border-red-500 @enderror">
                        @error('nisn')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- NIS -->
                    <div>
                        <label for="nis" class="block text-sm font-medium text-gray-700 mb-2">
                            NIS
                        </label>
                        <input wire:model="nis" type="text" id="nis" placeholder="Nomor Induk Siswa"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nis') border-red-500 @enderror">
                        @error('nis')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama -->
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input wire:model="nama" type="text" id="nama" placeholder="Nama lengkap siswa"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nama') border-red-500 @enderror">
                        @error('nama')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Arabic -->
                    <div>
                        <label for="nama_arabic" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Arabic
                        </label>
                        <input wire:model="nama_arabic" type="text" id="nama_arabic" placeholder="Nama dalam bahasa Arab"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nama_arabic') border-red-500 @enderror">
                        @error('nama_arabic')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2">
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="jenis_kelamin" id="jenis_kelamin"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('jenis_kelamin') border-red-500 @enderror">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tempat Lahir -->
                    <div>
                        <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 mb-2">
                            Tempat Lahir
                        </label>
                        <input wire:model="tempat_lahir" type="text" id="tempat_lahir" placeholder="Kota kelahiran"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('tempat_lahir') border-red-500 @enderror">
                        @error('tempat_lahir')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Lahir -->
                    <div>
                        <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Lahir
                        </label>
                        <input wire:model="tanggal_lahir" type="date" id="tanggal_lahir"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('tanggal_lahir') border-red-500 @enderror">
                        @error('tanggal_lahir')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Telepon -->
                    <div>
                        <label for="telepon" class="block text-sm font-medium text-gray-700 mb-2">
                            Telepon
                        </label>
                        <input wire:model="telepon" type="text" id="telepon" placeholder="08xxxxxxxxxx"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('telepon') border-red-500 @enderror">
                        @error('telepon')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email
                        </label>
                        <input wire:model="email" type="email" id="email" placeholder="email@example.com"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Masuk -->
                    <div>
                        <label for="tanggal_masuk" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Masuk
                        </label>
                        <input wire:model="tanggal_masuk" type="date" id="tanggal_masuk"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('tanggal_masuk') border-red-500 @enderror">
                        @error('tanggal_masuk')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="status" id="status"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror">
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                            <option value="Lulus">Lulus</option>
                            <option value="Pindah">Pindah</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Alamat (Full Width) -->
                    <div class="md:col-span-2">
                        <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                            Alamat
                        </label>
                        <textarea wire:model="alamat" id="alamat" rows="3" placeholder="Alamat lengkap"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('alamat') border-red-500 @enderror"></textarea>
                        @error('alamat')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Data Orang Tua -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200">Data Orang Tua</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Ayah -->
                    <div>
                        <label for="nama_ayah" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Ayah
                        </label>
                        <input wire:model="nama_ayah" type="text" id="nama_ayah" placeholder="Nama lengkap ayah"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nama_ayah') border-red-500 @enderror">
                        @error('nama_ayah')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Ibu -->
                    <div>
                        <label for="nama_ibu" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Ibu
                        </label>
                        <input wire:model="nama_ibu" type="text" id="nama_ibu" placeholder="Nama lengkap ibu"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nama_ibu') border-red-500 @enderror">
                        @error('nama_ibu')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Telepon Orang Tua -->
                    <div class="md:col-span-2">
                        <label for="telepon_ortu" class="block text-sm font-medium text-gray-700 mb-2">
                            Telepon Orang Tua
                        </label>
                        <input wire:model="telepon_ortu" type="text" id="telepon_ortu" placeholder="08xxxxxxxxxx"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('telepon_ortu') border-red-500 @enderror">
                        @error('telepon_ortu')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.siswa.index') }}" wire:navigate class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                    Perbarui
                </button>
            </div>
        </form>
    </div>
</div>
