@extends('layouts.dashboard')

@section('title', 'Media Manager - XI PPLG 2')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Media Manager</h1>
            <p class="text-xs text-slate-500">Pusat penyimpanan file, gambar, dan media portal kelas XI PPLG 2.</p>
        </div>

        <!-- Form Upload File -->
        <form action="{{ route('development.media.store') }}" method="POST" enctype="multipart/form-data" class="flex items-center space-x-2">
            @csrf
            <input type="file" name="file" required class="text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition shrink-0">
                UNGGAH BERKAS
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <!-- Grid File Media -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
        @forelse($mediaFiles as $media)
            <div class="bg-white p-3 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between space-y-3 hover:shadow-md transition">
                <div>
                    <!-- Preview Gambar/Icon -->
                    <div class="w-full h-28 bg-slate-100 rounded-xl overflow-hidden flex items-center justify-center relative">
                        @if(\Illuminate\Support\Str::startsWith($media->mime_type, 'image/'))
                            <img src="{{ Storage::url($media->storage_path) }}" alt="{{ $media->original_name }}" class="w-full h-full object-cover">
                            <span class="absolute top-1.5 right-1.5 px-1.5 py-0.5 bg-slate-900/70 text-white text-[9px] font-extrabold rounded uppercase backdrop-blur-sm">
                                {{ $media->extension }}
                            </span>
                        @else
                            <div class="text-center p-2">
                                <span class="text-xs font-black uppercase text-slate-400 block">{{ $media->extension }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Nama & Ukuran File -->
                    <div class="mt-2 space-y-0.5">
                        <p class="text-xs font-bold text-slate-800 truncate" title="{{ $media->original_name }}">
                            {{ $media->original_name }}
                        </p>
                        <p class="text-[10px] text-slate-400 font-mono">
                            {{ number_format(($media->size ?? $media->file_size) / 1024, 1) }} KB
                        </p>
                    </div>
                </div>

                <!-- Tombol Aksi: Edit & Hapus -->
                <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-[10px]">
                    <button type="button" onclick="openEditModal({{ $media->id }}, '{{ addslashes($media->original_name) }}')" class="font-bold text-blue-600 hover:underline">
                        Edit Nama
                    </button>

                    <form action="{{ route('development.media.destroy', $media->id) }}" method="POST" onsubmit="return confirm('Hapus file ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="font-bold text-rose-600 hover:underline">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center text-slate-400 text-xs">
                Belum ada file media yang diunggah.
            </div>
        @endforelse
    </div>

    <div>{{ $mediaFiles->links() }}</div>
</div>

<!-- Modal Edit Nama File -->
<div id="editModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm hidden items-center justify-center p-4 z-50">
    <div class="bg-white rounded-2xl p-6 max-w-sm w-full space-y-4 shadow-xl">
        <h3 class="text-sm font-extrabold text-slate-900">Ubah Nama File</h3>
        
        <form id="editForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <input type="text" id="fileNameInput" name="original_name" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-600">
            
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeEditModal()" class="px-3 py-1.5 rounded-xl text-xs font-semibold text-slate-500 hover:bg-slate-100">Batal</button>
                <button type="submit" class="px-4 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, name) {
        const modal = document.getElementById('editModal');
        const form = document.getElementById('editForm');
        const input = document.getElementById('fileNameInput');

        form.action = `/dev/media/${id}`;
        input.value = name;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeEditModal() {
        const modal = document.getElementById('editModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endsection