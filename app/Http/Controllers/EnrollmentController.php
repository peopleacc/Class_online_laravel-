<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\ClassEnrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    /**
     * Browse available classes
     */
    public function browse()
    {
        $enrolledClassIds = Auth::user()->enrolledClasses()->pluck('classes.id');

        // Get all classes (for now, we'll show all public classes)
        $classes = ClassRoom::with('guru')
            ->withCount('students')
            ->whereNotIn('id', $enrolledClassIds)
            ->latest()
            ->get();

        return view('mahasiswa.browse', compact('classes'));
    }

    /**
     * Show enrolled classes
     */
    public function myClasses()
    {
        $classes = Auth::user()->enrolledClasses()
            ->with('guru')
            ->withCount(['materials', 'assignments'])
            ->get();

        return view('mahasiswa.classes.index', compact('classes'));
    }

    /**
     * Join class using code
     */
    public function join(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $class = ClassRoom::where('code', strtoupper($request->code))->first();

        if (!$class) {
            return back()->withErrors(['code' => 'Kode kelas tidak ditemukan.']);
        }

        // Check if already enrolled
        if (Auth::user()->enrolledClasses()->where('class_id', $class->id)->exists()) {
            return back()->withErrors(['code' => 'Anda sudah terdaftar di kelas ini.']);
        }

        // Enroll
        ClassEnrollment::create([
            'class_id' => $class->id,
            'user_id' => Auth::id(),
            'enrolled_at' => now(),
        ]);

        return redirect()->route('mahasiswa.classes.show', $class)
            ->with('success', 'Berhasil bergabung ke kelas ' . $class->name . '!');
    }

    /**
     * Show class details for mahasiswa
     */
    public function show(ClassRoom $class)
    {
        // Check if mahasiswa is enrolled
        if (!Auth::user()->enrolledClasses()->where('class_id', $class->id)->exists()) {
            abort(403, 'Anda tidak terdaftar di kelas ini.');
        }

        $class->load(['guru', 'materials', 'assignments']);
        return view('mahasiswa.classes.show', compact('class'));
    }

    /**
     * Leave class
     */
    public function leave(ClassRoom $class)
    {
        Auth::user()->enrolledClasses()->detach($class->id);

        return redirect()->route('mahasiswa.classes.index')
            ->with('success', 'Berhasil keluar dari kelas ' . $class->name);
    }
}
