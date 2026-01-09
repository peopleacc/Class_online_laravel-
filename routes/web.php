<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\EnrollmentController;

// Landing Page
Route::get('/', function () {
    return view('welcome');
});

// Guest Routes (Login & Register)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard redirect based on role
    Route::get('/dashboard', function () {
        if (auth()->user()->isGuru()) {
            return redirect()->route('guru.dashboard');
        }
        return redirect()->route('mahasiswa.dashboard');
    })->name('dashboard');

    // =====================
    // GURU ROUTES
    // =====================
    Route::prefix('guru')->name('guru.')->middleware('auth')->group(function () {
        // Dashboard
        Route::get('/dashboard', function () {
            if (!auth()->user()->isGuru()) {
                abort(403);
            }
            return view('guru.dashboard');
        })->name('dashboard');

        // Classes
        Route::get('/classes', [ClassController::class, 'index'])->name('classes.index');
        Route::get('/classes/create', [ClassController::class, 'create'])->name('classes.create');
        Route::post('/classes', [ClassController::class, 'store'])->name('classes.store');
        Route::get('/classes/{class}', [ClassController::class, 'show'])->name('classes.show');
        Route::get('/classes/{class}/edit', [ClassController::class, 'edit'])->name('classes.edit');
        Route::put('/classes/{class}', [ClassController::class, 'update'])->name('classes.update');
        Route::delete('/classes/{class}', [ClassController::class, 'destroy'])->name('classes.destroy');

        // Materials
        Route::get('/classes/{class}/materials/create', [MaterialController::class, 'create'])->name('materials.create');
        Route::post('/classes/{class}/materials', [MaterialController::class, 'store'])->name('materials.store');
        Route::delete('/materials/{material}', [MaterialController::class, 'destroy'])->name('materials.destroy');

        // Assignments
        Route::get('/classes/{class}/assignments/create', [AssignmentController::class, 'create'])->name('assignments.create');
        Route::post('/classes/{class}/assignments', [AssignmentController::class, 'store'])->name('assignments.store');
        Route::delete('/assignments/{assignment}', [AssignmentController::class, 'destroy'])->name('assignments.destroy');
    });

    // =====================
    // MAHASISWA ROUTES
    // =====================
    Route::prefix('mahasiswa')->name('mahasiswa.')->middleware('auth')->group(function () {
        // Dashboard
        Route::get('/dashboard', function () {
            if (!auth()->user()->isMahasiswa()) {
                abort(403);
            }
            return view('mahasiswa.dashboard');
        })->name('dashboard');

        // Browse & Join
        Route::get('/browse', [EnrollmentController::class, 'browse'])->name('browse');
        Route::post('/join', [EnrollmentController::class, 'join'])->name('join');

        // My Classes
        Route::get('/classes', [EnrollmentController::class, 'myClasses'])->name('classes.index');
        Route::get('/classes/{class}', [EnrollmentController::class, 'show'])->name('classes.show');
        Route::delete('/classes/{class}/leave', [EnrollmentController::class, 'leave'])->name('leave');
    });

    // =====================
    // SHARED DOWNLOAD ROUTES
    // =====================
    Route::get('/materials/{material}/download', [MaterialController::class, 'download'])->name('materials.download');
    Route::get('/assignments/{assignment}/download', [AssignmentController::class, 'download'])->name('assignments.download');
});
