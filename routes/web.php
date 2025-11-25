<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\RegisterController;

// Livewire v3 Components - FIXED IMPORTS
use App\Livewire\CustomLogin;

// Admin
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\Doctors as AdminDoctor;
use App\Livewire\Admin\Patients as AdminPatient;
use App\Livewire\Admin\Pharmacy as AdminPharmacy;
use App\Livewire\Admin\Transactions as AdminTransaction;
use App\Livewire\Admin\Appointments as AdminAppointments;

// Patient
use App\Livewire\Patient\PatientDashboard;
use App\Livewire\Patient\SymptomChecker;
use App\Livewire\Patient\Appointments as PatientAppointments;
use App\Livewire\Patient\Chat;
use App\Livewire\Patient\Wallet;
use App\Livewire\Patient\Pharmacy as PatientPharmacy;

// Doctor
//use App\Livewire\Doctor\DoctorDashboard;
use App\Livewire\Doctor\Dashboard;
use App\Livewire\Doctor\Appointments as DoctorAppointments;
use App\Livewire\Doctor\Chat as DoctorChat;
use App\Livewire\Doctor\Patients as DoctorPatients;
use App\Livewire\Doctor\Wallet as DoctorWallet;
use App\Livewire\Doctor\Profile as DoctorProfile;

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

// Authentication
Route::get('/login', CustomLogin::class)->name('login')->middleware('guest');
Route::post('/register', [RegisterController::class, 'register'])->name('register')->middleware('guest');

// Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

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
        Route::get('/pharmacy', AdminPharmacy::class)->name('pharmacy');
        Route::get('/transactions', AdminTransaction::class)->name('transactions');
        Route::get('/appointments', AdminAppointments::class)->name('appointments');

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
        Route::get('/wallet', Wallet::class)->name('wallet');
        Route::get('/pharmacy', PatientPharmacy::class)->name('pharmacy');

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

    });

});