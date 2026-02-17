<x-app-layout>
    <div class="mb-6">
        <a href="{{ route('jadwal.index') }}" class="btn btn-ghost"> Kembali</a>
    </div>

    <div class="card bg-base-100 shadow-xl max-w-2xl mx-auto">
        <div class="card-body">
            <h2 class="card-title text-2xl mb-4">Tambah Jadwal Baru</h2>
            
            <form method="POST" action="{{ route('jadwal.store') }}">
                @csrf
                
                <div class="form-control mb-4">
                    <label class="label"><span class="label-text">Hari</span></label>
                    <select name="hari" class="select select-bordered" required>
                        <option value="">Pilih Hari</option>
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                        <option value="Sabtu">Sabtu</option>
                    </select>
                </div>

                <div class="form-control mb-4">
                    <label class="label"><span class="label-text">Waktu Mulai</span></label>
                    <input type="time" name="waktu_mulai" class="input input-bordered" required />
                </div>

                <div class="form-control mb-4">
                    <label class="label"><span class="label-text">Waktu Selesai</span></label>
                    <input type="time" name="waktu_selesai" class="input input-bordered" required />
                </div>

                <div class="form-control mb-4">
                    <label class="label"><span class="label-text">Ruangan</span></label>
                    <input type="text" name="ruangan" class="input input-bordered" required />
                </div>

                <div class="form-control mb-4">
                    <label class="label"><span class="label-text">Keterangan</span></label>
                    <textarea name="keterangan" class="textarea textarea-bordered"></textarea>
                </div>

                <button type="submit" class="btn btn-primary w-full">Simpan Jadwal</button>
            </form>
        </div>
    </div>
</x-app-layout>
