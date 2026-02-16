<x-app-layout>
    @section('title', 'Edit Jadwal')
    
    <div class="max-w-3xl mx-auto">
        <!-- Breadcrumb -->
        <div class="text-sm breadcrumbs mb-4">
            <ul>
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('jadwal.index') }}">Jadwal</a></li>
                <li>Edit Jadwal</li>
            </ul>
        </div>

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold">✏️ Edit Jadwal</h1>
            <p class="text-sm opacity-70 mt-2">Update informasi jadwal Anda</p>
        </div>

        <!-- Form Card -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <form method="POST" action="{{ route('jadwal.update', $jadwal->id) }}">
                    @csrf
                    @method('PUT')

                    <!-- Hari -->
                    <div class="form-control mb-4">
                        <label class="label">
                            <span class="label-text font-semibold">Hari *</span>
                        </label>
                        <select name="hari" 
                                class="select select-bordered w-full @error('hari') select-error @enderror" 
                                required>
                            <option value="" disabled>Pilih hari</option>
                            <option value="Senin" {{ old('hari', $jadwal->hari) == 'Senin' ? 'selected' : '' }}>📅 Senin</option>
                            <option value="Selasa" {{ old('hari', $jadwal->hari) == 'Selasa' ? 'selected' : '' }}>📅 Selasa</option>
                            <option value="Rabu" {{ old('hari', $jadwal->hari) == 'Rabu' ? 'selected' : '' }}>📅 Rabu</option>
                            <option value="Kamis" {{ old('hari', $jadwal->hari) == 'Kamis' ? 'selected' : '' }}>📅 Kamis</option>
                            <option value="Jumat" {{ old('hari', $jadwal->hari) == 'Jumat' ? 'selected' : '' }}>📅 Jumat</option>
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
                                   value="{{ old('jam_mulai', date('H:i', strtotime($jadwal->jam_mulai))) }}" 
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
                                   value="{{ old('jam_selesai', date('H:i', strtotime($jadwal->jam_selesai))) }}" 
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
                            <option value="" disabled>Pilih jenis kegiatan</option>
                            <option value="Mengajar" {{ old('kegiatan', $jadwal->kegiatan) == 'Mengajar' ? 'selected' : '' }}>📚 Mengajar</option>
                            <option value="Konsultasi" {{ old('kegiatan', $jadwal->kegiatan) == 'Konsultasi' ? 'selected' : '' }}>💬 Konsultasi</option>
                            <option value="Rapat" {{ old('kegiatan', $jadwal->kegiatan) == 'Rapat' ? 'selected' : '' }}>👥 Rapat</option>
                            <option value="Lainnya" {{ old('kegiatan', $jadwal->kegiatan) == 'Lainnya' ? 'selected' : '' }}>📌 Lainnya</option>
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
                               value="{{ old('ruangan', $jadwal->ruangan) }}">
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
                                  placeholder="Tambahkan keterangan jika diperlukan">{{ old('keterangan', $jadwal->keterangan) }}</textarea>
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
                            Update Jadwal
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Card -->
        <div class="card bg-error text-error-content shadow-xl mt-6">
            <div class="card-body">
                <h3 class="card-title">⚠️ Zona Bahaya</h3>
                <p class="text-sm">Hapus jadwal ini secara permanen. Tindakan ini tidak dapat dibatalkan.</p>
                <div class="card-actions justify-end">
                    <form method="POST" action="{{ route('jadwal.destroy', $jadwal->id) }}" 
                          onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline btn-error">
                            🗑️ Hapus Jadwal
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
