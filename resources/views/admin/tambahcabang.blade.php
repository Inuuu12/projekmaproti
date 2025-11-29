@extends('layouts.sidebar')

@section('content')
<div class="min-h-screen p-6 bg-gray-50">
    <div class="max-w-6xl mx-auto">
        {{-- Pesan Sukses/Error --}}
        @if(session('success'))
            <div class="mb-4 p-4 bg-gray-900 text-white rounded-lg border border-gray-800 shadow-lg">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @if($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg border border-red-200">
                <ul class="list-disc list-inside text-sm space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(session('warning'))
            <div class="mb-4 p-4 bg-gray-700 text-gray-100 rounded-lg border border-gray-600 shadow-lg">
                {{ session('warning') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-4 bg-gray-800 text-gray-200 rounded-lg border border-gray-700 shadow-lg">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        {{-- Header --}}
        <header class="bg-gray-800 text-white rounded-lg px-6 py-4 flex items-center justify-between mb-6 shadow-lg">
            <div>
                <h2 class="text-xl font-semibold">Kelola Cabang</h2>
                <p class="text-sm text-gray-300">Tambah, edit, atau hapus data cabang</p>
            </div>
        </header>

        {{-- Section Tabel Cabang --}}
        <section class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200">
            <div class="p-4 border-b border-gray-200 flex items-center justify-between bg-gray-200">
                <div class="text-sm text-gray-600">Daftar semua cabang yang terdaftar</div>
                <div class="flex items-center gap-4">
                    <button id="btn-open-modal"
                        class="px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition duration-200 font-medium shadow-md">
                        + Tambah Cabang
                    </button>
                </div>
            </div>

            {{-- Tabel Data Cabang --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm border-collapse">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold">No</th>
                            <th class="px-6 py-4 text-left font-semibold">Nama Cabang</th>
                            <th class="px-6 py-4 text-left font-semibold">Lokasi</th>
                            <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cabangs as $index => $cabang)
                            <tr class="border-t border-gray-200 hover:bg-gray-50 transition-colors hidden md:table-row">
                                <td class="px-6 py-4 text-gray-700">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $cabang->nama_cabang }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $cabang->lokasi }}</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button
                                            type="button"
                                            class="btn-edit px-3 py-1.5 bg-yellow-700 text-white rounded hover:bg-yellow-600 transition text-xs font-medium"
                                            data-id="{{ $cabang->id }}"
                                            data-nama="{{ $cabang->nama_cabang }}"
                                            data-lokasi="{{ $cabang->lokasi }}">
                                            Edit
                                        </button>
                                        <form action="{{ route('tambahcabang.destroy', $cabang->id) }}"
                                              method="POST"
                                              class="inline"
                                              onsubmit="return confirm('Yakin ingin menghapus cabang {{ $cabang->nama_cabang }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-3 py-1.5 bg-red-900 text-white rounded hover:bg-red-800 transition text-xs font-medium">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            {{-- Mobile stacked card for cabang --}}
                            <tr class="md:hidden">
                                <td colspan="4" class="px-4 py-3">
                                    <div class="bg-white p-3 rounded-lg shadow-sm">
                                        <div class="flex items-center justify-between">
                                            <div class="font-semibold text-gray-800">{{ $cabang->nama_cabang }}</div>
                                            <div class="text-sm text-gray-500">Lokasi</div>
                                        </div>
                                        <div class="mt-2 text-sm text-gray-600">{{ $cabang->lokasi }}</div>
                                        <div class="mt-3 flex gap-2">
                                            <button type="button" class="flex-1 px-3 py-2 bg-yellow-700 text-white rounded btn-edit" data-id="{{ $cabang->id }}" data-nama="{{ $cabang->nama_cabang }}" data-lokasi="{{ $cabang->lokasi }}">Edit</button>
                                            <form action="{{ route('tambahcabang.destroy', $cabang->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus cabang {{ $cabang->nama_cabang }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full px-3 py-2 bg-red-900 text-white rounded">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-gray-500 py-8 bg-gray-50">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        <span>Belum ada data cabang</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>

{{-- === MODAL TAMBAH CABANG === --}}
<div id="modal-cabang" class="hidden fixed inset-0 z-50 flex items-end md:items-center justify-center bg-black/60 p-4">
    <div class="bg-white rounded-t-lg md:rounded-xl w-full max-w-md shadow-2xl overflow-hidden border border-gray-200 flex flex-col h-[92vh] md:h-auto">
        <form id="form-cabang" action="{{ route('tambahcabang.store') }}" method="POST" class="flex flex-col flex-1 overflow-auto">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">
            <input type="hidden" name="cabang_id" id="cabang_id" value="">

            <div class="px-6 py-3 md:py-4 border-b border-gray-200 bg-gray-900 text-white flex justify-between items-center">
                <h3 class="text-xl font-bold" id="modal-title">➕ Tambah Cabang Baru</h3>
                <button type="button" id="modal-close" class="text-gray-300 hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="p-6 space-y-4 bg-gray-50">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Cabang</label>
                    <input type="text"
                           name="nama_cabang"
                           id="input-nama-cabang"
                           required
                           value="{{ old('nama_cabang') }}"
                           placeholder="Contoh: Cabang A"
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-white text-gray-900 focus:border-gray-700 focus:ring-2 focus:ring-gray-600 focus:outline-none transition">
                    @error('nama_cabang')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Lokasi</label>
                    <input type="text"
                           name="lokasi"
                           id="input-lokasi"
                           required
                           value="{{ old('lokasi') }}"
                           placeholder="Contoh: Jakarta Pusat"
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-white text-gray-900 focus:border-gray-700 focus:ring-2 focus:ring-gray-600 focus:outline-none transition">
                    @error('lokasi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div id="credential-fields" class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Username Admin Cabang</label>
                        <input type="text"
                               name="username"
                               id="input-username"
                               value="{{ old('username') }}"
                               placeholder="Contoh: cabang_jakarta"
                               class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-white text-gray-900 focus:border-gray-700 focus:ring-2 focus:ring-gray-600 focus:outline-none transition">
                        <p class="mt-1 text-xs text-gray-500">
                            Username ini akan disimpan di kolom {{ \Illuminate\Support\Facades\Schema::hasColumn('users', 'username') ? 'username' : 'name' }}.
                        </p>
                        @error('username')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Password Admin Cabang</label>
                        <input type="password"
                               name="password"
                               id="input-password"
                               placeholder="Minimal 8 karakter"
                               autocomplete="new-password"
                               class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-white text-gray-900 focus:border-gray-700 focus:ring-2 focus:ring-gray-600 focus:outline-none transition">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-100 border-t border-gray-200 flex justify-end gap-3 sticky bottom-0 md:static">
                <button type="button"
                    id="modal-close-footer"
                    class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition font-medium">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition font-medium shadow-md">
                    <span id="submit-text">Simpan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('modal-cabang');
    const btnOpen = document.getElementById('btn-open-modal');
    const btnClose = document.querySelectorAll('#modal-close, #modal-close-footer');
    const formCabang = document.getElementById('form-cabang');
    const formMethod = document.getElementById('form-method');
    const cabangId = document.getElementById('cabang_id');
    const inputNamaCabang = document.getElementById('input-nama-cabang');
    const inputLokasi = document.getElementById('input-lokasi');
    const credentialFields = document.getElementById('credential-fields');
    const inputUsername = document.getElementById('input-username');
    const inputPassword = document.getElementById('input-password');
    const modalTitle = document.getElementById('modal-title');
    const submitText = document.getElementById('submit-text');

    // Logika Buka Modal (Tambah Baru)
    btnOpen.addEventListener('click', () => {
        // Reset form
        formCabang.reset();
        formCabang.action = "{{ route('tambahcabang.store') }}";
        formMethod.value = 'POST';
        cabangId.value = '';
        credentialFields?.classList.remove('hidden');
        inputUsername?.setAttribute('required', 'required');
        inputPassword?.setAttribute('required', 'required');
        if (inputPassword) inputPassword.value = '';
        modalTitle.textContent = '➕ Tambah Cabang Baru';
        submitText.textContent = 'Simpan';

        modal.classList.remove('hidden');
    });

    // Logika Tutup Modal
    btnClose.forEach(b => b.addEventListener('click', () => {
        modal.classList.add('hidden');
        formCabang.reset();
    }));

    // Logika Tutup Modal (Klik di luar area gelap)
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.add('hidden');
            formCabang.reset();
        }
    });

    // Logika untuk tombol Edit
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const namaCabang = this.getAttribute('data-nama');
            const lokasi = this.getAttribute('data-lokasi');

            openEditModal(id, namaCabang, lokasi);
        });
    });
});

// Fungsi untuk membuka modal edit
function openEditModal(id, namaCabang, lokasi) {
    const modal = document.getElementById('modal-cabang');
    const formCabang = document.getElementById('form-cabang');
    const formMethod = document.getElementById('form-method');
    const cabangId = document.getElementById('cabang_id');
    const inputNamaCabang = document.getElementById('input-nama-cabang');
    const inputLokasi = document.getElementById('input-lokasi');
    const credentialFields = document.getElementById('credential-fields');
    const inputUsername = document.getElementById('input-username');
    const inputPassword = document.getElementById('input-password');
    const modalTitle = document.getElementById('modal-title');
    const submitText = document.getElementById('submit-text');

    // Set nilai form
    cabangId.value = id;
    inputNamaCabang.value = namaCabang;
    inputLokasi.value = lokasi;

    // Set action untuk update
    const updateRoute = "{{ route('tambahcabang.update', ':id') }}";
    formCabang.action = updateRoute.replace(':id', id);
    formMethod.value = 'PUT';

    // Update UI
    credentialFields?.classList.add('hidden');
    inputUsername?.removeAttribute('required');
    inputPassword?.removeAttribute('required');
    if (inputUsername) inputUsername.value = '';
    if (inputPassword) inputPassword.value = '';
    modalTitle.textContent = '✏️ Edit Cabang';
    submitText.textContent = 'Update';

    // Tampilkan modal
    modal.classList.remove('hidden');
}
</script>
@endsection
