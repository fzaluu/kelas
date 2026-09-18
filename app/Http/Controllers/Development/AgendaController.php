<?php

namespace App\Http\Controllers\Development;

use App\Http\Controllers\Controller;
use App\Models\Content\Agenda;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index(Request $request)
    {
        $query = Agenda::latest('start_at');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $agendas = $query->paginate(10)->withQueryString();

        return view('pages.development.public.agendas.index', compact('agendas'));
    }

    public function create()
    {
        return view('pages.development.public.agendas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'start_at'    => ['required', 'date'],
            'end_at'      => ['nullable', 'date', 'after_or_equal:start_at'],
            'location'    => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status'      => ['required', 'in:DRAFT,PUBLISHED,CANCELLED,COMPLETED'],
        ]);

        Agenda::create([
            'class_id'    => 1, // Default XI PPLG 2
            'title'       => $request->title,
            'description' => $request->description,
            'location'    => $request->location,
            'start_at'    => $request->start_at,
            'end_at'      => $request->end_at,
            'status'      => $request->status,
            'created_by'  => auth()->id(),
        ]);

        return redirect()->route('development.public.agendas.index')
            ->with('success', 'Agenda kegiatan berhasil ditambahkan!');
    }

    public function destroy(Agenda $agenda)
    {
        $agenda->delete();

        return redirect()->route('development.public.agendas.index')
            ->with('success', 'Agenda berhasil dihapus.');
    }
}