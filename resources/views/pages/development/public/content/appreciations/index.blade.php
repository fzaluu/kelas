@extends('layouts.dashboard')

@section('title', 'Kelola Prestasi Siswa - Admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Prestasi & Apresiasi</h1>
            <p class="text-xs text-slate-500">Kelola catatan kejuaraan dan penghargaan siswa XI PPLG 2.</p>
        </div>
        <a href="{{ route('development.content.appreciations.create') }}" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold transition">+ TAMBAH PRESTASI</a>
    </div>

    @if(session('success'))
        <div class="p-3.5 rounded-2xl bg-emerald-50 text-emerald-800 text-xs font-semibold">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @forelse($appreciations as $item)
            @php $media = $item->appreciationMedia->first()?->mediaFile; @endphp
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between space-y-3">
                <div class="space-y-2">
                    <div class="h-32 bg-slate-100 rounded-xl overflow-hidden">
                        @if($media) <img src="{{ $media->url }}" class="w-full h-full object-cover"> @endif
                    </div>
                    <h3 class="font-bold text-sm text-slate-900 truncate">{{ $item->title }}</h3>
                    <p class="text-xs text-slate-500 line-clamp-2">{{ $item->description }}</p>
                </div>
                <div class="pt-2 border-t flex justify-between items-center text-[10px]">
                    <span class="font-bold text-amber-600">{{ $item->status }}</span>
                    <form action="{{ route('development.content.appreciations.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus prestasi ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-rose-600 font-bold hover:underline">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-8 text-xs text-slate-400">Belum ada data prestasi yang tersimpan.</div>
        @endforelse
    </div>
</div>
@endsection