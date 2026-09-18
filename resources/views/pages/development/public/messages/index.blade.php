@extends('layouts.dashboard')

@section('title', 'Pesan Masukan & Kontak - XI PPLG 2')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Pesan & Masukan Pengunjung</h1>
        <p class="text-xs text-slate-500">Daftar kritik, saran, dan tanggapan yang dikirimkan melalui form halaman Kontak.</p>
    </div>

    @if(session('success'))
        <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/70 border-b border-slate-200/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                    <th class="py-3 px-4">Pengirim</th>
                    <th class="py-3 px-4">Subjek & Pesan</th>
                    <th class="py-3 px-4">Tanggal Kirim</th>
                    <th class="py-3 px-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                @forelse($messages as $msg)
                    @php
                        $nama = $msg->name ?? $msg->sender_name ?? $msg->full_name ?? 'Pengunjung';
                        $email = $msg->email ?? $msg->sender_email ?? '-';
                        $pesan = $msg->message ?? $msg->content ?? $msg->feedback ?? '-';
                        $subjek = $msg->subject ?? $msg->category ?? 'MASUKAN';
                    @endphp
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="py-3.5 px-4 space-y-0.5">
                            <p class="font-bold text-slate-900">{{ $nama }}</p>
                            <p class="text-[10px] text-slate-400 font-mono">{{ $email }}</p>
                        </td>
                        <td class="py-3.5 px-4 space-y-1 max-w-md">
                            <span class="px-2 py-0.5 rounded text-[9px] font-bold bg-blue-50 text-blue-700 border border-blue-100 uppercase">
                                {{ $subjek }}
                            </span>
                            <p class="text-xs text-slate-600 leading-relaxed">{{ $pesan }}</p>
                        </td>
                        <td class="py-3.5 px-4 text-[11px] font-mono text-slate-500">
                            {{ isset($msg->created_at) ? \Carbon\Carbon::parse($msg->created_at)->format('d M Y, H:i') : '-' }}
                        </td>
                        <td class="py-3.5 px-4 text-right">
                            <form action="{{ route('development.public.messages.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-[10px] text-rose-600 font-bold hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-12 text-center text-slate-400 italic">Belum ada pesan atau masukan masuk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(method_exists($messages, 'hasPages') && $messages->hasPages())
        <div>{{ $messages->links() }}</div>
    @endif
</div>
@endsection