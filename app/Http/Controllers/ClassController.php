<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassController extends Controller
{
    /**
     * Display list of classes for guru
     */
    public function index()
    {
        $classes = Auth::user()->ownedClasses()->withCount(['students', 'materials', 'assignments'])->latest()->get();
        return view('guru.classes.index', compact('classes'));
    }

    /**
     * Show form to create new class
     */
    public function create()
    {
        return view('guru.classes.create');
    }

    /**
     * Store a new class
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $class = ClassRoom::create([
            'guru_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'code' => ClassRoom::generateCode(),
        ]);

        return redirect()->route('guru.classes.show', $class)
            ->with('success', 'Kelas berhasil dibuat! Kode kelas: ' . $class->code);
    }

    /**
     * Display class details with materials and assignments
     */
    public function show(ClassRoom $class)
    {
        // Ensure guru owns this class
        if ($class->guru_id !== Auth::id()) {
            abort(403);
        }

        $class->load(['materials', 'assignments', 'students']);
        return view('guru.classes.show', compact('class'));
    }

    /**
     * Show form to edit class
     */
    public function edit(ClassRoom $class)
    {
        if ($class->guru_id !== Auth::id()) {
            abort(403);
        }

        return view('guru.classes.edit', compact('class'));
    }

    /**
     * Update class details
     */
    public function update(Request $request, ClassRoom $class)
    {
        if ($class->guru_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $class->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('guru.classes.show', $class)
            ->with('success', 'Kelas berhasil diupdate!');
    }

    /**
     * Delete class
     */
    public function destroy(ClassRoom $class)
    {
        if ($class->guru_id !== Auth::id()) {
            abort(403);
        }

        $class->delete();
        return redirect()->route('guru.classes.index')
            ->with('success', 'Kelas berhasil dihapus!');
    }
}
