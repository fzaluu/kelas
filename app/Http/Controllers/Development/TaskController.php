<?php

namespace App\Http\Controllers\Development;

use App\Http\Controllers\Controller;
use App\Models\Academic\Task;
use App\Models\Academic\Subject;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::with(['subject', 'creator'])->latest();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $tasks = $query->paginate(10)->withQueryString();

        return view('pages.development.academic.tasks.index', compact('tasks'));
    }

    public function create()
    {
        $subjects = Subject::orderBy('name')->get();
        return view('pages.development.academic.tasks.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'subject_id'  => ['required', 'exists:subjects,id'],
            'deadline'    => ['required', 'date'],
            'status'      => ['required', 'in:DRAFT,PUBLISHED,CLOSED,ARCHIVED'],
            'description' => ['required', 'string'],
        ]);

        $publishedAt = $request->status === 'PUBLISHED' ? now() : null;

        Task::create([
            'class_id'     => 1, // Default XI PPLG 2
            'subject_id'   => $request->subject_id,
            'title'        => $request->title,
            'description'  => $request->description,
            'deadline'     => $request->deadline,
            'status'       => $request->status,
            'published_at' => $publishedAt,
            'created_by'   => auth()->id(),
        ]);

        return redirect()->route('development.academic.tasks.index')
            ->with('success', 'Tugas akademik berhasil ditambahkan!');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('development.academic.tasks.index')
            ->with('success', 'Tugas berhasil dihapus.');
    }
}