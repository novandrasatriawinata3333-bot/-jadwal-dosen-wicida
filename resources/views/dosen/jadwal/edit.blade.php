<x-app-layout>
    @section('title', 'Edit Jadwal')
    
    <div class="max-w-3xl mx-auto">
        <h1 class="text-4xl font-bold mb-6">✏️ Edit Jadwal</h1>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <form method="POST" action="{{ route('jadwal.update', $jadwal) }}">
                    @csrf
                    @method('PUT')

                    <!-- Same form fields as create.blade.php but with $jadwal values -->
                    <div class="form-control mb-4">
                        <label class="label">
                            <span class="label-text font-semibold">Hari *</span>
                        </label>
                        <select name="hari" class="select select-bordered w-full" required>
                            <option value="Senin" {{ $jadwal->hari == 'Senin' ? 'selected' : '' }}>📅 Senin</option>
                            <option value="Selasa" {{ $jadwal->hari == 'Selasa' ? 'selected' : '' }}>📅 Selasa</option>
                            <option value="Rabu" {{ $jadwal->hari == 'Rabu' ? 'selected' : '' }}>📅 Rabu</option>
                            <option value="Kamis" {{ $jadwal->hari == 'Kamis' ? 'selected' : '' }}>📅 Kamis</option>
                            <option value="Jumat" {{ $jadwal->hari == 'Jumat' ? 'selected' : '' }}>📅 Jumat</option>
                        </select>
                    </div>

                    <div class="card-actions justify-end gap-2">
                        <a href="{{ route('jadwal.index') }}" class="btn btn-ghost">← Batal</a>
                        <button type="submit" class="btn btn-primary">💾 Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
