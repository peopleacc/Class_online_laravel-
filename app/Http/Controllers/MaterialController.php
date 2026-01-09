<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    /**
     * Show form to add material
     */
    public function create(ClassRoom $class)
    {
        if ($class->guru_id !== Auth::id()) {
            abort(403);
        }

        return view('guru.materials.create', compact('class'));
    }

    /**
     * Store new material
     */
    public function store(Request $request, ClassRoom $class)
    {
        if ($class->guru_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:pdf,video',
            'file' => 'required|file|max:51200', // 50MB max
        ]);

        // Validate file type based on material type
        $file = $request->file('file');
        $allowedMimes = $request->type === 'pdf'
            ? ['application/pdf']
            : ['video/mp4', 'video/webm', 'video/quicktime'];

        if (!in_array($file->getMimeType(), $allowedMimes)) {
            return back()->withErrors(['file' => 'Tipe file tidak sesuai dengan jenis materi yang dipilih.']);
        }

        // Store file
        $path = $file->store('materials', 'public');

        Material::create([
            'class_id' => $class->id,
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'file_path' => $path,
        ]);

        return redirect()->route('guru.classes.show', $class)
            ->with('success', 'Materi berhasil ditambahkan!');
    }

    /**
     * Download material file
     */
    public function download(Material $material)
    {
        $user = Auth::user();
        $class = $material->classRoom;

        // Check access: guru owns class OR mahasiswa is enrolled
        $hasAccess = ($user->isGuru() && $class->guru_id === $user->id) ||
            ($user->isMahasiswa() && $class->students()->where('user_id', $user->id)->exists());

        if (!$hasAccess) {
            abort(403);
        }

        return Storage::disk('public')->download($material->file_path, $material->title . '.' . pathinfo($material->file_path, PATHINFO_EXTENSION));
    }

    /**
     * Delete material
     */
    public function destroy(Material $material)
    {
        $class = $material->classRoom;

        if ($class->guru_id !== Auth::id()) {
            abort(403);
        }

        // Delete file
        Storage::disk('public')->delete($material->file_path);

        $material->delete();

        return redirect()->route('guru.classes.show', $class)
            ->with('success', 'Materi berhasil dihapus!');
    }
}
