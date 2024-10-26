<?php

use App\Http\Controllers\StudentAuthController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CounselorDashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ViolationController;
use App\Http\Controllers\RequirementController;
use App\Http\Controllers\UploadController; // Import the controller you will create

use Illuminate\Support\Facades\Route;

// Public routes for student registration and login
Route::get('student/register', [StudentAuthController::class, 'showRegistrationForm'])->name('student.register');
Route::post('student/register', [StudentAuthController::class, 'register'])->name('register');;

Route::get('student/login', [StudentAuthController::class, 'showLoginForm'])->name('student.login');
Route::post('student/login', [StudentAuthController::class, 'login'])->name('login');

Route::post('student/logout', [StudentAuthController::class, 'logout'])->name('student.logout');
Route::get('/uploads/{student}', [UploadController::class, 'show'])->name('uploads.show');

// Welcome route
Route::get('/', function () {
    return view('welcome');
});

// Routes requiring student authentication
Route::middleware(['auth:student'])->group(function () {
    // Student dashboard
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
    Route::get('/requirements', [RequirementController::class, 'index'])->name('student.requirements');
    Route::post('/requirements/upload', [RequirementController::class,'upload'])->name('student.requirements.upload');
    Route::delete('/requirements/delete/{id}', [RequirementController::class, 'delete'])->name('student.requirements.delete');
    Route::get('/requirements/download/{id}', [RequirementController::class, 'download'])->name('requirements.download');

    // Appointment routes
    Route::get('/student/appointments/create', function () {
        return view('student/appointment'); // Return the appointment booking view
    })->name('student.appointments.create');
    Route::get('/appointments/{id}', [AppointmentController::class, 'show']);

    Route::post('/student/appointments', [AppointmentController::class, 'store'])->name('student.appointments.store');
    Route::get('/student/appointments/{id}', [AppointmentController::class, 'show'])->name('student.appointments.show'); // Fetch appointment

    // Appointment management
    Route::post('/appointments/{appointment}/confirm', [AppointmentController::class, 'confirm'])->name('appointments.confirm');
    Route::post('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');

    // Student profile routes
    Route::get('/student/profile', [StudentController::class, 'edit'])->name('student.profile.edit');
    Route::post('/student/profile', [StudentController::class, 'update'])->name('student.profile.update');
});

// Counselor dashboard route (can be accessed without student auth)
Route::get('/counselor/dashboard', [CounselorDashboardController::class, 'index'])->name('counselor.dashboard');

// Violations route (assuming you want this accessible without auth)
Route::post('/violations/add', [ViolationController::class, 'addViolation'])->name('violations.add');
