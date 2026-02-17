<x-app-layout>
    <div class="mb-6">
        <a href="{{ route('jadwal.index') }}" class="btn btn-ghost"> Kembali</a>
    </div>

    <div class="card bg-base-100 shadow-xl max-w-2xl mx-auto">
        <div class="card-body">
            <h2 class="card-title text-2xl mb-4">Edit Jadwal</h2>
            
            <form method="POST" action="{{ route('jadwal.update', $jadwal->id) }}">
                @csrf
                @method('PUT')
                
                <div class="form-control mb-4">
                    <label class="label"><span class="label-text">Hari</span></label>
                    <select name="hari" class="select select-bordered" required>
                        <option value="Senin" {{ $jadwal->hari === 'Senin' ? 'selected' : '' }}>Senin</option>
                        <option value="Selasa" {{ $jadwal->hari === 'Selasa' ? 'selected' : '' }}>Selasa</option>
                        <option value="Rabu" {{ $jadwal->hari === 'Rabu' ? 'selected' : '' }}>Rabu</option>
                        <option value="Kamis" {{ $jadwal->hari === 'Kamis' ? 'selected' : '' }}>Kamis</option>
                        <option value="Jumat" {{ $jadwal->hari === 'Jumat' ? 'selected' : '' }}>Jumat</option>
                        <option value="Sabtu" {{ $jadwal->hari === 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                    </select>
                </div>

                <div class="form-control mb-4">
                    <label class="label"><span class="label-text">Waktu Mulai</span></label>
                    <input type="time" name="waktu_mulai" value="{{ $jadwal->waktu_mulai }}" class="input input-bordered" required />
                </div>

                <div class="form-control mb-4">
                    <label class="label"><span class="label-text">Waktu Selesai</span></label>
                    <input type="time" name="waktu_selesai" value="{{ $jadwal->waktu_selesai }}" class="input input-bordered" required />
                </div>

                <div class="form-control mb-4">
                    <label class="label"><span class="label-text">Ruangan</span></label>
                    <input type="text" name="ruangan" value="{{ $jadwal->ruangan }}" class="input input-bordered" required />
                </div>

                <div class="form-control mb-4">
                    <label class="label"><span class="label-text">Keterangan</span></label>
                    <textarea name="keterangan" class="textarea textarea-bordered">{{ $jadwal->keterangan }}</textarea>
                </div>

                <div class="form-control mb-4">
                    <label class="cursor-pointer label">
                        <span class="label-text">Status Aktif</span>
                        <input type="checkbox" name="is_active" value="1" class="checkbox" {{ $jadwal->is_active ? 'checked' : '' }} />
                    </label>
                </div>

                <button type="submit" class="btn btn-primary w-full">Update Jadwal</button>
            </form>
        </div>
    </div>
</x-app-layout>
