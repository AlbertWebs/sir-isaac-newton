<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\SchoolController;
use App\Http\Controllers\Api\V1\AcademicsController;
use App\Http\Controllers\Api\V1\StudentController as ApiStudentController;
use App\Http\Controllers\Api\V1\TransportController;
use App\Http\Controllers\Api\V1\ExtracurricularController;
use App\Http\Controllers\Api\V1\AnnouncementController;
use App\Http\Controllers\Api\V1\NotificationController;
use App\Http\Controllers\Api\V1\WebsiteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public Website API Routes
Route::prefix('website')->group(function () {
    Route::get('/school-info', [WebsiteController::class, 'schoolInfo']);
    Route::get('/homepage', [WebsiteController::class, 'homepage']);
    Route::get('/about', [WebsiteController::class, 'about']);
    Route::get('/classes', [WebsiteController::class, 'classes']);
    Route::get('/gallery', [WebsiteController::class, 'gallery']);
    Route::get('/contact', [WebsiteController::class, 'contact']);
    Route::post('/contact/submit', [\App\Http\Controllers\Admin\Website\ContactController::class, 'submit'])->name('api.website.contact.submit');
    Route::get('/breadcrumb/{pageKey}', [WebsiteController::class, 'breadcrumb']);
    Route::get('/programs', [WebsiteController::class, 'programs']);
    Route::get('/announcements', [WebsiteController::class, 'announcements']);
});

// Authentication Routes
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:sanctum');
    Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');
});

// Protected API Routes
Route::middleware('auth:sanctum')->group(function () {
    
    // School Information
    Route::prefix('school')->group(function () {
        Route::get('/', [SchoolController::class, 'index']);
        Route::put('/', [SchoolController::class, 'update'])->middleware('permission:school.edit');
    });

    // Academics
    Route::prefix('academics')->group(function () {
        Route::get('/classes', [AcademicsController::class, 'classes']);
        Route::get('/classes/{classId}/subjects', [AcademicsController::class, 'classSubjects']);
        Route::get('/subjects', [AcademicsController::class, 'subjects']);
        Route::get('/timetables', [AcademicsController::class, 'timetables']);
        Route::get('/attendance', [AcademicsController::class, 'attendance']);
        Route::post('/attendance/mark', [AcademicsController::class, 'markAttendance'])->middleware('permission:attendance.mark');
        Route::get('/exams', [AcademicsController::class, 'exams']);
        Route::get('/results', [AcademicsController::class, 'results']);
        Route::post('/results', [AcademicsController::class, 'storeResult'])->middleware('permission:results.create');
    });

    // Students
    Route::prefix('students')->group(function () {
        Route::get('/', [ApiStudentController::class, 'index'])->middleware('permission:students.view');
        Route::get('/{id}', [ApiStudentController::class, 'show'])->middleware('permission:students.view');
        Route::post('/', [ApiStudentController::class, 'store'])->middleware('permission:students.create');
        Route::put('/{id}', [ApiStudentController::class, 'update'])->middleware('permission:students.edit');
        Route::get('/{id}/attendance', [ApiStudentController::class, 'attendance'])->middleware('permission:attendance.view');
        Route::get('/{id}/results', [ApiStudentController::class, 'results'])->middleware('permission:results.view');
    });

    // Transportation
    Route::prefix('transport')->group(function () {
        // Routes
        Route::get('/routes', [TransportController::class, 'routes'])->middleware('permission:routes.view');
        Route::get('/routes/{id}', [TransportController::class, 'showRoute'])->middleware('permission:routes.view');
        Route::post('/routes', [TransportController::class, 'createRoute'])->middleware('permission:routes.create');
        Route::put('/routes/{id}', [TransportController::class, 'updateRoute'])->middleware('permission:routes.edit');
        Route::delete('/routes/{id}', [TransportController::class, 'deleteRoute'])->middleware('permission:routes.delete');
        
        // Route Assignments
        Route::post('/routes/{id}/assign-students', [TransportController::class, 'assignStudents'])->middleware('permission:routes.assign_students');
        
        // Driver Routes
        Route::get('/driver/my-routes', [TransportController::class, 'myRoutes'])->middleware('permission:routes.view_assigned');
        Route::get('/driver/trip/{tripId}/students', [TransportController::class, 'tripStudents'])->middleware('permission:routes.view_assigned');
        Route::post('/driver/pickup/{logId}', [TransportController::class, 'markPickup'])->middleware('permission:routes.mark_pickup');
        
        // Vehicles
        Route::get('/vehicles', [TransportController::class, 'vehicles'])->middleware('permission:vehicles.view');
        Route::post('/vehicles', [TransportController::class, 'createVehicle'])->middleware('permission:vehicles.create');
        
        // Drivers
        Route::get('/drivers', [TransportController::class, 'drivers'])->middleware('permission:drivers.view');
        Route::post('/drivers', [TransportController::class, 'createDriver'])->middleware('permission:drivers.create');
        
        // Status
        Route::get('/status/{studentId}', [TransportController::class, 'studentStatus'])->middleware('permission:transport.view_status');
    });

    // Extracurricular
    Route::prefix('extracurricular')->group(function () {
        Route::get('/clubs', [ExtracurricularController::class, 'clubs']);
        Route::get('/clubs/{id}', [ExtracurricularController::class, 'showClub']);
        Route::post('/clubs', [ExtracurricularController::class, 'createClub'])->middleware('permission:clubs.create');
        Route::get('/clubs/{id}/members', [ExtracurricularController::class, 'clubMembers']);
        Route::post('/clubs/{id}/members', [ExtracurricularController::class, 'addMember'])->middleware('permission:clubs.manage_members');
    });

    // Announcements
    Route::prefix('announcements')->group(function () {
        Route::get('/', [AnnouncementController::class, 'index']);
        Route::get('/{id}', [AnnouncementController::class, 'show']);
        Route::post('/', [AnnouncementController::class, 'store'])->middleware('permission:announcements.create');
        Route::put('/{id}', [AnnouncementController::class, 'update'])->middleware('permission:announcements.edit');
        Route::delete('/{id}', [AnnouncementController::class, 'destroy'])->middleware('permission:announcements.delete');
    });

    // Notifications
    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'index']);
        Route::get('/unread', [NotificationController::class, 'unread']);
        Route::post('/{id}/read', [NotificationController::class, 'markAsRead']);
        Route::post('/{id}/read-all', [NotificationController::class, 'markAllAsRead']);
    });
});

