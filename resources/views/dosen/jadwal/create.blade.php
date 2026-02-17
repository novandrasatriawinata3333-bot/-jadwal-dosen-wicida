<x-app-layout>
    @section('title', 'Tambah Jadwal')
    
    <div class="max-w-3xl mx-auto">
        <!-- Breadcrumb -->
        <div class="text-sm breadcrumbs mb-4">
            <ul>
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('jadwal.index') }}">Jadwal</a></li>
                <li>Tambah Jadwal</li>
            </ul>
        </div>

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold">➕ Tambah Jadwal Baru</h1>
            <p class="text-sm opacity-70 mt-2">Isi form di bawah untuk menambahkan jadwal</p>
        </div>

        <!-- Form Card -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <form method="POST" action="{{ route('jadwal.store') }}">
                    @csrf

                    <!-- Hari -->
                    <div class="form-control mb-4">
                        <label class="label">
                            <span class="label-text font-semibold">Hari *</span>
                        </label>
                        <select name="hari" 
                                class="select select-bordered w-full @error('hari') select-error @enderror" 
                                required>
                            <option value="" disabled selected>Pilih hari</option>
                            <option value="Senin" {{ old('hari') == 'Senin' ? 'selected' : '' }}>📅 Senin</option>
                            <option value="Selasa" {{ old('hari') == 'Selasa' ? 'selected' : '' }}>📅 Selasa</option>
                            <option value="Rabu" {{ old('hari') == 'Rabu' ? 'selected' : '' }}>📅 Rabu</option>
                            <option value="Kamis" {{ old('hari') == 'Kamis' ? 'selected' : '' }}>📅 Kamis</option>
                            <option value="Jumat" {{ old('hari') == 'Jumat' ? 'selected' : '' }}>📅 Jumat</option>
                        </select>
                        @error('hari')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Waktu -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Jam Mulai *</span>
                            </label>
                            <input type="time" 
                                   name="jam_mulai" 
                                   class="input input-bordered @error('jam_mulai') input-error @enderror" 
                                   value="{{ old('jam_mulai') }}" 
                                   required>
                            @error('jam_mulai')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Jam Selesai *</span>
                            </label>
                            <input type="time" 
                                   name="jam_selesai" 
                                   class="input input-bordered @error('jam_selesai') input-error @enderror" 
                                   value="{{ old('jam_selesai') }}" 
                                   required>
                            @error('jam_selesai')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>

                    <!-- Kegiatan -->
                    <div class="form-control mb-4">
                        <label class="label">
                            <span class="label-text font-semibold">Jenis Kegiatan *</span>
                        </label>
                        <select name="kegiatan" 
                                class="select select-bordered w-full @error('kegiatan') select-error @enderror" 
                                required>
                            <option value="" disabled selected>Pilih jenis kegiatan</option>
                            <option value="Mengajar" {{ old('kegiatan') == 'Mengajar' ? 'selected' : '' }}>📚 Mengajar</option>
                            <option value="Konsultasi" {{ old('kegiatan') == 'Konsultasi' ? 'selected' : '' }}>💬 Konsultasi</option>
                            <option value="Rapat" {{ old('kegiatan') == 'Rapat' ? 'selected' : '' }}>👥 Rapat</option>
                            <option value="Lainnya" {{ old('kegiatan') == 'Lainnya' ? 'selected' : '' }}>📌 Lainnya</option>
                        </select>
                        @error('kegiatan')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Ruangan -->
                    <div class="form-control mb-4">
                        <label class="label">
                            <span class="label-text font-semibold">Ruangan</span>
                            <span class="label-text-alt">(Opsional)</span>
                        </label>
                        <input type="text" 
                               name="ruangan" 
                               placeholder="Contoh: Lab WICIDA 101"
                               class="input input-bordered @error('ruangan') input-error @enderror" 
                               value="{{ old('ruangan') }}">
                        @error('ruangan')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Keterangan -->
                    <div class="form-control mb-6">
                        <label class="label">
                            <span class="label-text font-semibold">Keterangan</span>
                            <span class="label-text-alt">(Opsional)</span>
                        </label>
                        <textarea name="keterangan" 
                                  class="textarea textarea-bordered h-24 @error('keterangan') textarea-error @enderror" 
                                  placeholder="Tambahkan keterangan jika diperlukan">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Actions -->
                    <div class="card-actions justify-end gap-2">
                        <a href="{{ route('jadwal.index') }}" class="btn btn-ghost">
                            ← Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Jadwal
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info Card -->
        <div class="alert alert-info mt-6">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h3 class="font-bold">Tips</h3>
                <div class="text-xs">
                    <ul class="list-disc list-inside">
                        <li>Pastikan tidak ada jadwal yang bentrok</li>
                        <li>Jam selesai harus lebih besar dari jam mulai</li>
                        <li>Gunakan keterangan untuk informasi tambahan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
