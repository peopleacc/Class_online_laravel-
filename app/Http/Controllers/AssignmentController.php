<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    /**
     * Show form to create assignment
     */
    public function create(ClassRoom $class)
    {
        if ($class->guru_id !== Auth::id()) {
            abort(403);
        }

        return view('guru.assignments.create', compact('class'));
    }

    /**
     * Store new assignment
     */
    public function store(Request $request, ClassRoom $class)
    {
        if ($class->guru_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:pdf|max:10240', // 10MB max for PDF
            'due_date' => 'nullable|date|after:now',
        ]);

        $file = $request->file('file');
        $path = $file->store('assignments', 'public');

        Assignment::create([
            'class_id' => $class->id,
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $path,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('guru.classes.show', $class)
            ->with('success', 'Tugas berhasil dibuat!');
    }

    /**
     * Download assignment file
     */
    public function download(Assignment $assignment)
    {
        $user = Auth::user();
        $class = $assignment->classRoom;

        // Check access: guru owns class OR mahasiswa is enrolled
        $hasAccess = ($user->isGuru() && $class->guru_id === $user->id) ||
            ($user->isMahasiswa() && $class->students()->where('user_id', $user->id)->exists());

        if (!$hasAccess) {
            abort(403);
        }

        return Storage::disk('public')->download($assignment->file_path, $assignment->title . '.pdf');
    }

    /**
     * Delete assignment
     */
    public function destroy(Assignment $assignment)
    {
        $class = $assignment->classRoom;

        if ($class->guru_id !== Auth::id()) {
            abort(403);
        }

        Storage::disk('public')->delete($assignment->file_path);
        $assignment->delete();

        return redirect()->route('guru.classes.show', $class)
            ->with('success', 'Tugas berhasil dihapus!');
    }
}
