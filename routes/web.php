<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\StudentLoginController;
use App\Http\Controllers\Auth\TeacherLoginController;
use App\Http\Controllers\BankDepositController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseRegistrationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataPurgeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\FeeBalanceController;
use App\Http\Controllers\MoneyTraceController;
use App\Http\Controllers\MobileDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\StudentPortalController;
use App\Http\Controllers\TeacherPortalController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ============================================
// PUBLIC WEBSITE ROUTES
// ============================================
Route::get('/', [\App\Http\Controllers\WebsiteController::class, 'homepage'])->name('website.homepage');
Route::get('/about', [\App\Http\Controllers\WebsiteController::class, 'about'])->name('website.about');
Route::get('/classes', [\App\Http\Controllers\WebsiteController::class, 'classes'])->name('website.classes');
Route::get('/gallery', [\App\Http\Controllers\WebsiteController::class, 'gallery'])->name('website.gallery');
Route::get('/contact', [\App\Http\Controllers\WebsiteController::class, 'contact'])->name('website.contact');
Route::get('/enroll', [\App\Http\Controllers\WebsiteController::class, 'enroll'])->name('website.enroll');
Route::post('/enroll', [\App\Http\Controllers\WebsiteController::class, 'enrollSubmit'])->name('website.enroll.submit');

// ============================================
// ADMIN AUTHENTICATION ROUTES
// ============================================
Route::prefix('admin')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
});

// Student Login Routes (Public)
Route::get('/student/login', [StudentLoginController::class, 'showLoginForm'])->name('student.login');
Route::post('/student/login', [StudentLoginController::class, 'login']);
Route::post('/student/logout', [StudentLoginController::class, 'logout'])->name('student.logout');

// Teacher Login Routes (Public)
Route::get('/teacher/login', [TeacherLoginController::class, 'showLoginForm'])->name('teacher.login');
Route::post('/teacher/login', [TeacherLoginController::class, 'login']);
Route::post('/teacher/logout', [TeacherLoginController::class, 'logout'])->name('teacher.logout');

// ============================================
// PUBLIC WEBSITE ROUTES
// ============================================
Route::get('/', [\App\Http\Controllers\WebsiteController::class, 'homepage'])->name('website.homepage');
Route::get('/about', [\App\Http\Controllers\WebsiteController::class, 'about'])->name('website.about');
Route::get('/classes', [\App\Http\Controllers\WebsiteController::class, 'classes'])->name('website.classes');
Route::get('/gallery', [\App\Http\Controllers\WebsiteController::class, 'gallery'])->name('website.gallery');
Route::get('/contact', [\App\Http\Controllers\WebsiteController::class, 'contact'])->name('website.contact');
Route::get('/enroll', [\App\Http\Controllers\WebsiteController::class, 'enroll'])->name('website.enroll');
Route::post('/enroll', [\App\Http\Controllers\WebsiteController::class, 'enrollSubmit'])->name('website.enroll.submit');

// ============================================
// ADMIN ROUTES (Protected)
// ============================================
Route::prefix('admin')->group(function () {
    // Admin Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [LoginController::class, 'login']);
    
    // Protected Admin Routes
    Route::middleware('auth')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Students
    Route::post('/students/{student}/send-welcome-sms', [StudentController::class, 'sendWelcomeSMS'])->name('students.send-welcome-sms');
    Route::resource('students', StudentController::class);

    // Courses
    Route::resource('courses', CourseController::class);

    // Course Registrations
    Route::get('/course-registrations', [CourseRegistrationController::class, 'index'])->name('course-registrations.index');
    Route::get('/course-registrations/create', [CourseRegistrationController::class, 'create'])->name('course-registrations.create');
    Route::post('/course-registrations', [CourseRegistrationController::class, 'store'])->name('course-registrations.store');
    Route::delete('/course-registrations/{courseRegistration}', [CourseRegistrationController::class, 'destroy'])->name('course-registrations.destroy');

    // Billing
    Route::get('/billing', [BillingController::class, 'index'])->name('billing.index');
    Route::post('/billing', [BillingController::class, 'store'])->name('billing.store');
    Route::get('/billing/class/{classId}', [BillingController::class, 'getClassInfo'])->name('billing.class-info');
    Route::get('/billing/student/{studentId}/classes', [BillingController::class, 'getStudentClasses'])->name('billing.student-classes');

    // Receipts
    Route::get('/receipts', [ReceiptController::class, 'index'])->name('receipts.index');
    Route::get('/receipts/{id}', [ReceiptController::class, 'show'])->name('receipts.show');
    Route::get('/receipts/{id}/print', [ReceiptController::class, 'print'])->name('receipts.print');
    Route::get('/receipts/{id}/print-bw', [ReceiptController::class, 'printBw'])->name('receipts.print-bw');
    Route::get('/receipts/{id}/thermal', [ReceiptController::class, 'thermal'])->name('receipts.thermal');

    // Expenses (Cashier and Super Admin)
    Route::resource('expenses', ExpenseController::class);

    // Bank Deposits (Cashier and Super Admin)
    Route::get('/bank-deposits/get-balance', [BankDepositController::class, 'getBalance'])->name('bank-deposits.get-balance');
    Route::resource('bank-deposits', BankDepositController::class);

    // Mobile Dashboard (Super Admin only)
    Route::get('/mobile', [MobileDashboardController::class, 'index'])->name('mobile.dashboard');

    // Reports (Super Admin only - checked in controller)
    Route::get('/reports', [ReportController::class, 'module'])->name('reports.index');
    Route::get('/reports/financial', [ReportController::class, 'index'])->name('reports.financial');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
    Route::get('/reports/export-payments', [ReportController::class, 'exportPayments'])->name('reports.export-payments');
    Route::get('/reports/export-expenses', [ReportController::class, 'exportExpenses'])->name('reports.export-expenses');
    Route::get('/reports/export-students-registered', [ReportController::class, 'exportStudentsRegistered'])->name('reports.export-students-registered');
    Route::get('/reports/export-balances', [ReportController::class, 'exportBalances'])->name('reports.export-balances');
    Route::get('/reports/export-course-registrations', [ReportController::class, 'exportCourseRegistrations'])->name('reports.export-course-registrations');
    Route::get('/reports/export-bank-deposits', [ReportController::class, 'exportBankDeposits'])->name('reports.export-bank-deposits');
    Route::get('/reports/export-receipts', [ReportController::class, 'exportReceipts'])->name('reports.export-receipts');

    // Fee Balances (Super Admin only - checked in controller)
    Route::get('/fee-balances', [FeeBalanceController::class, 'index'])->name('fee-balances.index');
    Route::post('/fee-balances/send-reminders', [FeeBalanceController::class, 'sendReminders'])->name('fee-balances.send-reminders');

    // Money Trace (Super Admin only - checked in controller)
    Route::get('/money-trace', [MoneyTraceController::class, 'index'])->name('money-trace.index');

    // Users & Roles (Super Admin only - checked in controller)
    Route::resource('users', UserController::class);

    // Teachers Management (Super Admin only - checked in controller)
    Route::name('admin.')->group(function () {
        Route::resource('teachers', TeacherController::class);
        Route::resource('drivers', \App\Http\Controllers\Admin\DriverController::class);
        Route::resource('classes', \App\Http\Controllers\Admin\ClassController::class);
        Route::resource('subjects', \App\Http\Controllers\Admin\SubjectController::class);
        Route::resource('timetables', \App\Http\Controllers\Admin\TimetableController::class);
        Route::get('timetables/download/pdf', [\App\Http\Controllers\Admin\TimetableController::class, 'downloadPdf'])->name('timetables.download-pdf');
        Route::resource('clubs', \App\Http\Controllers\Admin\ClubController::class);
        Route::resource('routes', \App\Http\Controllers\Admin\RouteController::class);
        Route::resource('vehicles', \App\Http\Controllers\Admin\VehicleController::class);
        Route::resource('announcements', \App\Http\Controllers\Admin\AnnouncementController::class);

        // Website Management
        Route::prefix('website')->name('website.')->group(function () {
            // Homepage
            Route::get('homepage', [\App\Http\Controllers\Admin\Website\HomepageController::class, 'index'])->name('homepage.index');
            
            // Sliders
            Route::get('homepage/sliders', [\App\Http\Controllers\Admin\Website\HomepageController::class, 'slidersIndex'])->name('homepage.sliders.index');
            Route::get('homepage/sliders/create', [\App\Http\Controllers\Admin\Website\HomepageController::class, 'slidersCreate'])->name('homepage.sliders.create');
            Route::post('homepage/sliders', [\App\Http\Controllers\Admin\Website\HomepageController::class, 'slidersStore'])->name('homepage.sliders.store');
            Route::get('homepage/sliders/{slider}/edit', [\App\Http\Controllers\Admin\Website\HomepageController::class, 'slidersEdit'])->name('homepage.sliders.edit');
            Route::put('homepage/sliders/{slider}', [\App\Http\Controllers\Admin\Website\HomepageController::class, 'slidersUpdate'])->name('homepage.sliders.update');
            Route::delete('homepage/sliders/{slider}', [\App\Http\Controllers\Admin\Website\HomepageController::class, 'slidersDestroy'])->name('homepage.sliders.destroy');
            
            // Sections
            Route::get('homepage/sections', [\App\Http\Controllers\Admin\Website\HomepageController::class, 'sectionsIndex'])->name('homepage.sections.index');
            Route::get('homepage/sections/create', [\App\Http\Controllers\Admin\Website\HomepageController::class, 'sectionsCreate'])->name('homepage.sections.create');
            Route::post('homepage/sections', [\App\Http\Controllers\Admin\Website\HomepageController::class, 'sectionsStore'])->name('homepage.sections.store');
            Route::get('homepage/sections/{section}/edit', [\App\Http\Controllers\Admin\Website\HomepageController::class, 'sectionsEdit'])->name('homepage.sections.edit');
            Route::put('homepage/sections/{section}', [\App\Http\Controllers\Admin\Website\HomepageController::class, 'sectionsUpdate'])->name('homepage.sections.update');
            Route::delete('homepage/sections/{section}', [\App\Http\Controllers\Admin\Website\HomepageController::class, 'sectionsDestroy'])->name('homepage.sections.destroy');
            
            // Features
            Route::get('homepage/features', [\App\Http\Controllers\Admin\Website\HomepageController::class, 'featuresIndex'])->name('homepage.features.index');
            Route::get('homepage/features/create', [\App\Http\Controllers\Admin\Website\HomepageController::class, 'featuresCreate'])->name('homepage.features.create');
            Route::post('homepage/features', [\App\Http\Controllers\Admin\Website\HomepageController::class, 'featuresStore'])->name('homepage.features.store');
            Route::get('homepage/features/{feature}/edit', [\App\Http\Controllers\Admin\Website\HomepageController::class, 'featuresEdit'])->name('homepage.features.edit');
            Route::put('homepage/features/{feature}', [\App\Http\Controllers\Admin\Website\HomepageController::class, 'featuresUpdate'])->name('homepage.features.update');
            Route::delete('homepage/features/{feature}', [\App\Http\Controllers\Admin\Website\HomepageController::class, 'featuresDestroy'])->name('homepage.features.destroy');
            
            // FAQs
            Route::get('homepage/faqs', [\App\Http\Controllers\Admin\Website\HomepageController::class, 'faqsIndex'])->name('homepage.faqs.index');
            Route::get('homepage/faqs/create', [\App\Http\Controllers\Admin\Website\HomepageController::class, 'faqsCreate'])->name('homepage.faqs.create');
            Route::post('homepage/faqs', [\App\Http\Controllers\Admin\Website\HomepageController::class, 'faqsStore'])->name('homepage.faqs.store');
            Route::get('homepage/faqs/{faq}/edit', [\App\Http\Controllers\Admin\Website\HomepageController::class, 'faqsEdit'])->name('homepage.faqs.edit');
            Route::put('homepage/faqs/{faq}', [\App\Http\Controllers\Admin\Website\HomepageController::class, 'faqsUpdate'])->name('homepage.faqs.update');
            Route::delete('homepage/faqs/{faq}', [\App\Http\Controllers\Admin\Website\HomepageController::class, 'faqsDestroy'])->name('homepage.faqs.destroy');
            
            // Session Times
            Route::get('homepage/session-times', [\App\Http\Controllers\Admin\Website\HomepageController::class, 'sessionTimesIndex'])->name('homepage.session-times.index');
            Route::get('homepage/session-times/create', [\App\Http\Controllers\Admin\Website\HomepageController::class, 'sessionTimesCreate'])->name('homepage.session-times.create');
            Route::post('homepage/session-times', [\App\Http\Controllers\Admin\Website\HomepageController::class, 'sessionTimesStore'])->name('homepage.session-times.store');
            Route::get('homepage/session-times/{sessionTime}/edit', [\App\Http\Controllers\Admin\Website\HomepageController::class, 'sessionTimesEdit'])->name('homepage.session-times.edit');
            Route::put('homepage/session-times/{sessionTime}', [\App\Http\Controllers\Admin\Website\HomepageController::class, 'sessionTimesUpdate'])->name('homepage.session-times.update');
            Route::delete('homepage/session-times/{sessionTime}', [\App\Http\Controllers\Admin\Website\HomepageController::class, 'sessionTimesDestroy'])->name('homepage.session-times.destroy');
            
            // About Page
            Route::get('about', [\App\Http\Controllers\Admin\Website\AboutController::class, 'index'])->name('about.index');
            Route::get('about/about-school/edit', [\App\Http\Controllers\Admin\Website\AboutController::class, 'aboutSchoolEdit'])->name('about.about-school.edit');
            Route::put('about/about-school', [\App\Http\Controllers\Admin\Website\AboutController::class, 'aboutSchoolUpdate'])->name('about.about-school.update');
            
            // Team
            Route::get('about/team', [\App\Http\Controllers\Admin\Website\AboutController::class, 'teamIndex'])->name('about.team.index');
            Route::get('about/team/create', [\App\Http\Controllers\Admin\Website\AboutController::class, 'teamCreate'])->name('about.team.create');
            Route::post('about/team', [\App\Http\Controllers\Admin\Website\AboutController::class, 'teamStore'])->name('about.team.store');
            Route::get('about/team/{teamMember}/edit', [\App\Http\Controllers\Admin\Website\AboutController::class, 'teamEdit'])->name('about.team.edit');
            Route::put('about/team/{teamMember}', [\App\Http\Controllers\Admin\Website\AboutController::class, 'teamUpdate'])->name('about.team.update');
            Route::delete('about/team/{teamMember}', [\App\Http\Controllers\Admin\Website\AboutController::class, 'teamDestroy'])->name('about.team.destroy');
            
            // Timeline
            Route::get('about/timeline', [\App\Http\Controllers\Admin\Website\AboutController::class, 'timelineIndex'])->name('about.timeline.index');
            Route::get('about/timeline/create', [\App\Http\Controllers\Admin\Website\AboutController::class, 'timelineCreate'])->name('about.timeline.create');
            Route::post('about/timeline', [\App\Http\Controllers\Admin\Website\AboutController::class, 'timelineStore'])->name('about.timeline.store');
            Route::get('about/timeline/{timeline}/edit', [\App\Http\Controllers\Admin\Website\AboutController::class, 'timelineEdit'])->name('about.timeline.edit');
            Route::put('about/timeline/{timeline}', [\App\Http\Controllers\Admin\Website\AboutController::class, 'timelineUpdate'])->name('about.timeline.update');
            Route::delete('about/timeline/{timeline}', [\App\Http\Controllers\Admin\Website\AboutController::class, 'timelineDestroy'])->name('about.timeline.destroy');
            
            // Clubs
            Route::get('about/clubs', [\App\Http\Controllers\Admin\Website\AboutController::class, 'clubsIndex'])->name('about.clubs.index');
            Route::get('about/clubs/create', [\App\Http\Controllers\Admin\Website\AboutController::class, 'clubsCreate'])->name('about.clubs.create');
            Route::post('about/clubs', [\App\Http\Controllers\Admin\Website\AboutController::class, 'clubsStore'])->name('about.clubs.store');
            Route::get('about/clubs/{club}/edit', [\App\Http\Controllers\Admin\Website\AboutController::class, 'clubsEdit'])->name('about.clubs.edit');
            Route::put('about/clubs/{club}', [\App\Http\Controllers\Admin\Website\AboutController::class, 'clubsUpdate'])->name('about.clubs.update');
            Route::delete('about/clubs/{club}', [\App\Http\Controllers\Admin\Website\AboutController::class, 'clubsDestroy'])->name('about.clubs.destroy');
            
            // Gallery
            Route::get('gallery', [\App\Http\Controllers\Admin\Website\GalleryController::class, 'index'])->name('gallery.index');
            Route::get('gallery/create', [\App\Http\Controllers\Admin\Website\GalleryController::class, 'create'])->name('gallery.create');
            Route::post('gallery', [\App\Http\Controllers\Admin\Website\GalleryController::class, 'store'])->name('gallery.store');
            Route::post('gallery/multiple', [\App\Http\Controllers\Admin\Website\GalleryController::class, 'storeMultiple'])->name('gallery.store-multiple');
            Route::get('gallery/{galleryImage}', [\App\Http\Controllers\Admin\Website\GalleryController::class, 'show'])->name('gallery.show');
            Route::get('gallery/{galleryImage}/edit', [\App\Http\Controllers\Admin\Website\GalleryController::class, 'edit'])->name('gallery.edit');
            Route::put('gallery/{galleryImage}', [\App\Http\Controllers\Admin\Website\GalleryController::class, 'update'])->name('gallery.update');
            Route::delete('gallery/{galleryImage}', [\App\Http\Controllers\Admin\Website\GalleryController::class, 'destroy'])->name('gallery.destroy');
            Route::post('gallery/{galleryImage}/toggle-visibility', [\App\Http\Controllers\Admin\Website\GalleryController::class, 'toggleVisibility'])->name('gallery.toggle-visibility');
            
            // Contact
            Route::get('contact', [\App\Http\Controllers\Admin\Website\ContactController::class, 'index'])->name('contact.index');
            Route::get('contact/edit', [\App\Http\Controllers\Admin\Website\ContactController::class, 'edit'])->name('contact.edit');
            Route::put('contact', [\App\Http\Controllers\Admin\Website\ContactController::class, 'update'])->name('contact.update');
            Route::get('contact/submissions/{submission}', [\App\Http\Controllers\Admin\Website\ContactController::class, 'showSubmission'])->name('contact.show');
            Route::delete('contact/submissions/{submission}', [\App\Http\Controllers\Admin\Website\ContactController::class, 'destroySubmission'])->name('contact.destroy');
            
            // Classes
            Route::get('classes', [\App\Http\Controllers\Admin\Website\ClassesController::class, 'index'])->name('classes.index');
            Route::get('classes/{class}/edit', [\App\Http\Controllers\Admin\Website\ClassesController::class, 'edit'])->name('classes.edit');
            Route::put('classes/{class}', [\App\Http\Controllers\Admin\Website\ClassesController::class, 'update'])->name('classes.update');
            
            // Breadcrumbs
            Route::get('breadcrumbs', [\App\Http\Controllers\Admin\Website\BreadcrumbController::class, 'index'])->name('breadcrumbs.index');
            Route::get('breadcrumbs/create', [\App\Http\Controllers\Admin\Website\BreadcrumbController::class, 'create'])->name('breadcrumbs.create');
            Route::post('breadcrumbs', [\App\Http\Controllers\Admin\Website\BreadcrumbController::class, 'store'])->name('breadcrumbs.store');
            Route::get('breadcrumbs/{breadcrumb}/edit', [\App\Http\Controllers\Admin\Website\BreadcrumbController::class, 'edit'])->name('breadcrumbs.edit');
            Route::put('breadcrumbs/{breadcrumb}', [\App\Http\Controllers\Admin\Website\BreadcrumbController::class, 'update'])->name('breadcrumbs.update');
            Route::delete('breadcrumbs/{breadcrumb}', [\App\Http\Controllers\Admin\Website\BreadcrumbController::class, 'destroy'])->name('breadcrumbs.destroy');
        });
    });

    // Role Permissions (Super Admin only - checked in controller)
    Route::get('/role-permissions', [RolePermissionController::class, 'index'])->name('role-permissions.index');
    Route::put('/role-permissions/{role}', [RolePermissionController::class, 'update'])->name('role-permissions.update');

    // Profile (All authenticated users)
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');

    // Settings (Super Admin only - checked in controller)
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');

    // Bulk SMS (Super Admin only - checked in controller)
    Route::get('/bulk-sms', [\App\Http\Controllers\BulkSmsController::class, 'index'])->name('bulk-sms.index');
    Route::post('/bulk-sms/send', [\App\Http\Controllers\BulkSmsController::class, 'send'])->name('bulk-sms.send');
    Route::get('/bulk-sms/students', [\App\Http\Controllers\BulkSmsController::class, 'getStudents'])->name('bulk-sms.students');
    Route::get('/bulk-sms/teachers', [\App\Http\Controllers\BulkSmsController::class, 'getTeachers'])->name('bulk-sms.teachers');

    // Data Purge (Super Admin only - checked in controller)
    Route::get('/data-purge', [DataPurgeController::class, 'index'])->name('data-purge.index');
    Route::post('/data-purge', [DataPurgeController::class, 'purge'])->name('data-purge.purge');

    // Student Portal (requires student authentication)
    Route::prefix('student-portal')->name('student-portal.')->middleware('student.auth')->group(function () {
        Route::get('/', [StudentPortalController::class, 'index'])->name('index');
        Route::get('/financial-info', [StudentPortalController::class, 'financialInfo'])->name('financial-info');
        Route::get('/courses', [StudentPortalController::class, 'courses'])->name('courses');
        Route::get('/announcements', [StudentPortalController::class, 'announcements'])->name('announcements');
        Route::get('/results', [StudentPortalController::class, 'results'])->name('results');
        Route::get('/settings', [StudentPortalController::class, 'settings'])->name('settings');
        Route::post('/change-password', [StudentPortalController::class, 'changePassword'])->name('change-password');
        Route::post('/upload-photo', [StudentPortalController::class, 'uploadPhoto'])->name('upload-photo');
        Route::post('/logout', [StudentLoginController::class, 'logout'])->name('logout');
        
        // Student-accessible receipt routes
        Route::get('/receipts/{id}', [ReceiptController::class, 'studentShow'])->name('receipts.show');
        Route::get('/receipts/{id}/print', [ReceiptController::class, 'studentPrint'])->name('receipts.print');
        Route::get('/receipts/{id}/print-bw', [ReceiptController::class, 'studentPrintBw'])->name('receipts.print-bw');
        Route::get('/receipts/{id}/thermal', [ReceiptController::class, 'studentThermal'])->name('receipts.thermal');
    });

    // Teacher Portal (requires teacher authentication)
    Route::prefix('teacher-portal')->name('teacher-portal.')->middleware('teacher.auth')->group(function () {
        Route::get('/', [TeacherPortalController::class, 'index'])->name('index');
        Route::get('/personal-info', [TeacherPortalController::class, 'personalInfo'])->name('personal-info');
        Route::get('/courses', [TeacherPortalController::class, 'courses'])->name('courses');
        Route::get('/student-progress', [TeacherPortalController::class, 'studentProgress'])->name('student-progress');
        Route::get('/post-results', [TeacherPortalController::class, 'postResults'])->name('post-results');
        Route::post('/post-results', [TeacherPortalController::class, 'storeResult'])->name('store-result');
        Route::get('/results/{id}/edit', [TeacherPortalController::class, 'editResult'])->name('edit-result');
        Route::put('/results/{id}', [TeacherPortalController::class, 'updateResult'])->name('update-result');
        Route::get('/communicate', [TeacherPortalController::class, 'communicate'])->name('communicate');
        Route::post('/communicate', [TeacherPortalController::class, 'storeAnnouncement'])->name('store-announcement');
        Route::get('/announcements/{id}/edit', [TeacherPortalController::class, 'editAnnouncement'])->name('edit-announcement');
        Route::put('/announcements/{id}', [TeacherPortalController::class, 'updateAnnouncement'])->name('update-announcement');
        Route::delete('/announcements/{id}', [TeacherPortalController::class, 'deleteAnnouncement'])->name('delete-announcement');
        Route::get('/attendance', [TeacherPortalController::class, 'attendance'])->name('attendance');
        Route::post('/attendance', [TeacherPortalController::class, 'markAttendance'])->name('mark-attendance');
        Route::get('/courses/{courseId}/students', [TeacherPortalController::class, 'getCourseStudents'])->name('course-students');
        Route::get('/settings', [TeacherPortalController::class, 'settings'])->name('settings');
        Route::post('/change-password', [TeacherPortalController::class, 'changePassword'])->name('change-password');
        Route::post('/upload-photo', [TeacherPortalController::class, 'uploadPhoto'])->name('upload-photo');
        Route::put('/personal-info', [TeacherPortalController::class, 'updatePersonalInfo'])->name('update-personal-info');
        Route::post('/logout', [TeacherLoginController::class, 'logout'])->name('logout');
    });
});
});