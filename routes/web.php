<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;

// Livewire v3 Components
use App\Livewire\CustomLogin;

// Admin
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\Doctors as AdminDoctor;
use App\Livewire\Admin\Patients as AdminPatient;
use App\Livewire\Admin\PharmacyAdmin;
use App\Livewire\Admin\Appointments as AdminAppointments;
use App\Livewire\Admin\WalletManager;
use App\Livewire\Admin\WalletTransactions;

// Patient
use App\Livewire\Patient\PatientDashboard;
use App\Livewire\Patient\SymptomChecker;
use App\Livewire\Patient\Appointments as PatientAppointments;
use App\Livewire\Patient\Chat;
use App\Livewire\Patient\PatientWallet;
use App\Livewire\Patient\PatientPharmacy;

// Doctor
use App\Livewire\Doctor\Dashboard;
use App\Livewire\Doctor\Appointments as DoctorAppointments;
use App\Livewire\Doctor\Chat as DoctorChat;
use App\Livewire\Doctor\Patients as DoctorPatients;
use App\Livewire\Doctor\DoctorWallet;
use App\Livewire\Doctor\Profile as DoctorProfile;
use App\Livewire\Doctor\PrescriptionModal;

// Prescription Controller
use App\Http\Controllers\PrescriptionController;

// Landing
use App\Livewire\Landing\IndexPage;
use App\Livewire\Landing\AboutPage;
use App\Livewire\Landing\ServicesPage;
use App\Livewire\Landing\DoctorPage;
use App\Livewire\Landing\ContactPage;
use App\Livewire\Landing\ApointmentPage;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', IndexPage::class)->name('welcome');
Route::get('/about', AboutPage::class)->name('about');
Route::get('/services', ServicesPage::class)->name('services');
Route::get('/doctors', DoctorPage::class)->name('doctors');
Route::get('/contact', ContactPage::class)->name('contact');
Route::get('/appointment', ApointmentPage::class)->name('appointment');

/*
|--------------------------------------------------------------------------
| Authentication Routes (Fixed Version)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', CustomLogin::class)->name('login');
    
    // Registration - Using Laravel Fortify/Jetstream default
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');
});

// Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

/*
|--------------------------------------------------------------------------
| Prescription Routes (Public/Protected)
|--------------------------------------------------------------------------
*/

// Download prescription by message ID (for chat)
Route::get('/prescription/download/{message}', function ($messageId) {
    // This route will be handled by the controller
    return app(\App\Http\Controllers\PrescriptionController::class)->downloadByMessage($messageId);
})->name('prescription.download')->middleware('auth');

// Download prescription by prescription ID
Route::get('/prescriptions/{prescription}/download', function ($prescriptionId) {
    return app(\App\Http\Controllers\PrescriptionController::class)->download($prescriptionId);
})->name('prescriptions.download')->middleware('auth');

// View prescription details
Route::get('/prescriptions/{prescription}', function ($prescriptionId) {
    return app(\App\Http\Controllers\PrescriptionController::class)->show($prescriptionId);
})->name('prescriptions.show')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {

    // Profile
    Route::get('/user/profile', function () {
        return view('profile.show');
    })->name('profile.show');

    /*
    |--------------------------------------------------------------------------
    | ADMIN ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', AdminDashboard::class)->name('dashboard');
        Route::get('/patients', AdminPatient::class)->name('patients');
        Route::get('/doctors', AdminDoctor::class)->name('doctors');
        Route::get('/pharmacy', PharmacyAdmin::class)->name('pharmacy');
        Route::get('/appointments', AdminAppointments::class)->name('appointments');
        
        // Wallet Management Routes
        Route::get('/wallet-management', WalletManager::class)->name('wallet.management');
        Route::get('/wallet-transactions', WalletTransactions::class)->name('wallet.transactions');
        
        // Admin Prescription Routes
        Route::get('/prescriptions', function () {
            // Admin view of all prescriptions
            return view('admin.prescriptions.index');
        })->name('prescriptions.index');
    });

    /*
    |--------------------------------------------------------------------------
    | PATIENT ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:patient')->prefix('patient')->name('patient.')->group(function () {
        Route::get('/dashboard', PatientDashboard::class)->name('dashboard');
        Route::get('/symptom-checker', SymptomChecker::class)->name('symptom-checker');
        Route::get('/appointments', PatientAppointments::class)->name('appointments');
        Route::get('/chat', Chat::class)->name('chat');
        Route::get('/wallet', PatientWallet::class)->name('wallet');
        Route::get('/pharmacy', PatientPharmacy::class)->name('pharmacy');
        
        // Patient Prescription Routes
        Route::get('/prescriptions', function () {
            // Patient view of their prescriptions
            return view('patient.prescriptions.index');
        })->name('prescriptions');
        
        Route::get('/prescriptions/{prescription}', function ($prescriptionId) {
            // Patient view of specific prescription
            return view('patient.prescriptions.view', ['prescriptionId' => $prescriptionId]);
        })->name('prescriptions.view');
    });

    /*
    |--------------------------------------------------------------------------
    | DOCTOR ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:doctor')->prefix('doctor')->name('doctor.')->group(function () {
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        Route::get('/appointments', DoctorAppointments::class)->name('appointments');
        Route::get('/chat', DoctorChat::class)->name('chat');
        Route::get('/patients', DoctorPatients::class)->name('patients');
        Route::get('/wallet', DoctorWallet::class)->name('wallet');
        Route::get('/profile', DoctorProfile::class)->name('profile');
        
        // Doctor Prescription Routes
        Route::get('/prescriptions', function () {
            // Doctor view of their prescriptions
            return view('doctor.prescriptions.index');
        })->name('prescriptions');
        
        // Prescription Modal Component
        Route::get('/prescription/modal', PrescriptionModal::class)->name('prescription.modal');
        
        // Generate PDF route
        Route::post('/prescription/generate', function (Request $request) {
            return app(\App\Http\Controllers\PrescriptionController::class)->generate($request);
        })->name('prescription.generate');
        
        // Send prescription to patient
        Route::post('/prescription/{prescription}/send', function ($prescriptionId) {
            return app(\App\Http\Controllers\PrescriptionController::class)->sendToPatient($prescriptionId);
        })->name('prescription.send');
    });
});