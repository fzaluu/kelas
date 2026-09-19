@extends('layouts.dashboard')

@section('title', 'Kelola Karya Siswa - Admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Karya & Project Showcase</h1>
            <p class="text-xs text-slate-500">Kelola portfolio dan karya buatan siswa XI PPLG 2.</p>
        </div>
        <a href="{{ route('development.content.projects.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition">+ TAMBAH KARYA</a>
    </div>

    @if(session('success'))
        <div class="p-3.5 rounded-2xl bg-emerald-50 text-emerald-800 text-xs font-semibold">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @forelse($projects as $item)
            @php $media = $item->projectMedia->first()?->mediaFile; @endphp
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between space-y-3">
                <div class="space-y-2">
                    <div class="h-32 bg-slate-100 rounded-xl overflow-hidden">
                        @if($media) <img src="{{ $media->url }}" class="w-full h-full object-cover"> @endif
                    </div>
                    <h3 class="font-bold text-sm text-slate-900 truncate">{{ $item->title }}</h3>
                    <p class="text-xs text-slate-500 line-clamp-2">{{ $item->description }}</p>
                </div>
                <div class="pt-2 border-t flex justify-between items-center text-[10px]">
                    <span class="font-bold text-emerald-600">{{ $item->status }}</span>
                    <form action="{{ route('development.content.projects.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus karya ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-rose-600 font-bold hover:underline">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-8 text-xs text-slate-400">Belum ada karya siswa yang tersimpan.</div>
        @endforelse
    </div>
</div>
@endsection