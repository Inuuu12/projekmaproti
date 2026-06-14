@extends('layouts.sidebar')

@section('content')
<div class="min-h-screen p-6 bg-gray-100">
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
        <header class="bg-[#151D29] text-white rounded-2xl p-6 flex items-center justify-between mb-6 shadow-sm border border-gray-800/60 relative overflow-hidden">
            <div class="relative z-10">
                <h2 class="text-xl font-bold tracking-wide">Kelola Cabang</h2>
                <p class="text-xs text-gray-400 mt-1">Tambah, edit, atau hapus data cabang</p>
            </div>
        </header>

        {{-- Section Tabel Cabang --}}
        <section class="bg-white rounded-2xl shadow-sm border border-gray-200/80 overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-gray-50/50">
                <div class="text-xs text-gray-500 font-bold uppercase tracking-wider">
                    Daftar Semua Cabang Yang Terdaftar
                </div>
                <div>
                    <button id="btn-open-modal"
                        class="flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 active:scale-[0.98] text-white rounded-xl transition shadow-sm font-bold text-xs uppercase tracking-wider w-full sm:w-auto">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        <span>Tambah Cabang</span>
                    </button>
                </div>
            </div>

            {{-- Tabel Data Cabang --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm border-collapse">
                    <thead class="bg-gray-50/75 border-b border-gray-100 text-gray-500 uppercase text-[10px] font-bold tracking-wider">
                        <tr>
                            <th class="px-5 py-3.5 text-left font-bold">No</th>
                            <th class="px-5 py-3.5 text-left font-bold">Nama Cabang</th>
                            <th class="px-5 py-3.5 text-left font-bold">Lokasi</th>
                            <th class="px-5 py-3.5 text-center font-bold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($cabangs as $index => $cabang)
                            <tr class="hover:bg-gray-50/80 transition-all duration-200 hidden md:table-row">
                                <td class="px-5 py-4 text-gray-400 text-xs font-semibold">{{ $index + 1 }}</td>
                                <td class="px-5 py-4 font-bold text-gray-800 text-sm">{{ $cabang->nama_cabang }}</td>
                                <td class="px-5 py-4 text-gray-600 text-sm font-medium">{{ $cabang->lokasi }}</td>
                                <td class="px-5 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button
                                            type="button"
                                            class="btn-edit px-3 py-1.5 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition text-xs font-bold"
                                            data-id="{{ $cabang->id }}"
                                            data-nama="{{ $cabang->nama_cabang }}"
                                            data-lokasi="{{ $cabang->lokasi }}">
                                            Edit
                                        </button>
                                        <form action="{{ route('tambahcabang.destroy', $cabang->id) }}"
                                              method="POST"
                                              class="delete-form inline"
                                              data-confirm="Yakin ingin menghapus cabang '{{ $cabang->nama_cabang }}'?"
                                              data-title="Hapus Cabang">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-3 py-1.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-xs font-bold">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            {{-- Mobile stacked card for cabang --}}
                            <tr class="md:hidden">
                                <td colspan="4" class="px-4 py-3">
                                    <div class="bg-white p-4 rounded-xl border border-gray-150 shadow-sm space-y-2.5">
                                        <div class="flex items-center justify-between">
                                            <div class="font-bold text-gray-800">{{ $cabang->nama_cabang }}</div>
                                            <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Lokasi</div>
                                        </div>
                                        <div class="text-sm text-gray-600 font-medium">{{ $cabang->lokasi }}</div>
                                        <div class="mt-3 flex gap-2">
                                            <button type="button" class="flex-1 px-3 py-2 bg-amber-500 text-white rounded-lg btn-edit font-bold text-xs" data-id="{{ $cabang->id }}" data-nama="{{ $cabang->nama_cabang }}" data-lokasi="{{ $cabang->lokasi }}">Edit</button>
                                            <form action="{{ route('tambahcabang.destroy', $cabang->id) }}" method="POST" class="delete-form flex-1" data-confirm="Yakin ingin menghapus cabang '{{ $cabang->nama_cabang }}'?" data-title="Hapus Cabang">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full px-3 py-2 bg-red-600 text-white rounded-lg font-bold text-xs">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-gray-500 py-12 bg-white">
                                    <div class="flex flex-col items-center justify-center gap-3">
                                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        <span class="font-semibold text-xs">Belum ada data cabang</span>
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
<div id="modal-cabang" class="hidden fixed inset-0 z-50 flex items-end md:items-center justify-center bg-black/60 backdrop-blur-sm p-4 transition-opacity duration-300">
    <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl overflow-hidden border border-gray-100 flex flex-col h-[85vh] md:h-auto transform scale-95 opacity-0 transition-all duration-300" id="modal-cabang-card">
        <form id="form-cabang" action="{{ route('tambahcabang.store') }}" method="POST" class="flex flex-col flex-1 overflow-auto bg-white">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">
            <input type="hidden" name="cabang_id" id="cabang_id" value="">

            <div class="px-6 py-4 border-b border-gray-100 bg-white flex justify-between items-center text-gray-900">
                <h3 class="text-lg font-bold text-gray-900" id="modal-title">Tambah Cabang</h3>
                <button type="button" id="modal-close" class="text-gray-400 hover:text-gray-600 transition text-lg">✕</button>
            </div>

            <div class="p-6 space-y-4 bg-gray-50/50">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Nama Cabang</label>
                    <input type="text"
                           name="nama_cabang"
                           id="input-nama-cabang"
                           required
                           value="{{ old('nama_cabang') }}"
                           placeholder="Contoh: Cabang A"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition">
                    @error('nama_cabang')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Lokasi</label>
                    <input type="text"
                           name="lokasi"
                           id="input-lokasi"
                           required
                           value="{{ old('lokasi') }}"
                           placeholder="Contoh: Jakarta Pusat"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition">
                    @error('lokasi')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div id="credential-fields" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Username Admin Cabang</label>
                        <input type="text"
                               name="username"
                               id="input-username"
                               value="{{ old('username') }}"
                               placeholder="Contoh: cabang_jakarta"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition">
                        <p class="mt-1.5 text-[10px] font-semibold text-gray-400 uppercase tracking-wider">
                            Username disimpan di kolom {{ \Illuminate\Support\Facades\Schema::hasColumn('users', 'username') ? 'username' : 'name' }}.
                        </p>
                        @error('username')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Password Admin Cabang</label>
                        <input type="password"
                               name="password"
                               id="input-password"
                               placeholder="Minimal 8 karakter"
                               autocomplete="new-password"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition">
                        @error('password')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3 sticky bottom-0 md:static">
                <button type="button"
                    id="modal-close-footer"
                    class="px-5 py-2.5 bg-white border border-gray-200 text-gray-600 rounded-xl hover:bg-gray-100 transition font-bold text-xs">
                    Batal
                </button>
                <button type="submit"
                    class="px-5 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition font-bold text-xs shadow-sm">
                    <span id="submit-text">Simpan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('modal-cabang');
    const modalCard = document.getElementById('modal-cabang-card');
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

    const closeModal = () => {
        modalCard.classList.remove('scale-100', 'opacity-100');
        modalCard.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
            formCabang.reset();
        }, 200);
    };

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
        modalTitle.textContent = 'Tambah Cabang';
        submitText.textContent = 'Simpan';

        modal.classList.remove('hidden');
        setTimeout(() => {
            modalCard.classList.remove('scale-95', 'opacity-0');
            modalCard.classList.add('scale-100', 'opacity-100');
        }, 10);
    });

    // Logika Tutup Modal
    btnClose.forEach(b => b.addEventListener('click', closeModal));

    // Logika Tutup Modal (Klik di luar area gelap)
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModal();
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
    const modalCard = document.getElementById('modal-cabang-card');
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
    modalTitle.textContent = 'Edit Cabang';
    submitText.textContent = 'Update';

    // Tampilkan modal
    modal.classList.remove('hidden');
    setTimeout(() => {
        modalCard.classList.remove('scale-95', 'opacity-0');
        modalCard.classList.add('scale-100', 'opacity-100');
    }, 10);
}
</script>
@endsection
