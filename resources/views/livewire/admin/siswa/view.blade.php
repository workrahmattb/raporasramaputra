<div>
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <a href="{{ route('admin.siswa.index') }}" wire:navigate class="text-gray-600 hover:text-gray-900 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Detail Siswa</h1>
                    <p class="text-gray-600 mt-1">Informasi lengkap data siswa</p>
                </div>
            </div>
            <a href="{{ route('admin.siswa.edit', $siswa->id) }}" wire:navigate class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition inline-flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Data
            </a>
        </div>
    </div>

    <!-- Student Info Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Data Siswa -->
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Data Siswa</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">NISN</label>
                    <p class="text-gray-900">{{ $siswa->nisn ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">NIS</label>
                    <p class="text-gray-900">{{ $siswa->nis ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Nama Lengkap</label>
                    <p class="text-gray-900 font-semibold">{{ $siswa->nama }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Jenis Kelamin</label>
                    <p class="text-gray-900">{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Tempat, Tanggal Lahir</label>
                    <p class="text-gray-900">
                        {{ $siswa->tempat_lahir ?? '-' }}{{ $siswa->tanggal_lahir ? ', ' . \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d F Y') : '' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Kontak -->
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Kontak</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-500 mb-1">Alamat</label>
                    <p class="text-gray-900">{{ $siswa->alamat ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Telepon</label>
                    <p class="text-gray-900">{{ $siswa->telepon ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                    <p class="text-gray-900">{{ $siswa->email ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Data Orang Tua -->
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Data Orang Tua</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Nama Ayah</label>
                    <p class="text-gray-900">{{ $siswa->nama_ayah ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Nama Ibu</label>
                    <p class="text-gray-900">{{ $siswa->nama_ibu ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Telepon Orang Tua</label>
                    <p class="text-gray-900">{{ $siswa->telepon_ortu ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Data Sekolah -->
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Data Sekolah</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Masuk</label>
                    <p class="text-gray-900">
                        {{ $siswa->tanggal_masuk ? \Carbon\Carbon::parse($siswa->tanggal_masuk)->format('d F Y') : '-' }}
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                        {{ $siswa->status == 'Aktif' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $siswa->status == 'Tidak Aktif' ? 'bg-gray-100 text-gray-800' : '' }}
                        {{ $siswa->status == 'Lulus' ? 'bg-blue-100 text-blue-800' : '' }}
                        {{ $siswa->status == 'Pindah' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                        {{ $siswa->status }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
