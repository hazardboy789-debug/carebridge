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
    $message = \App\Models\ChatMessage::findOrFail($messageId);
    
    // Check permission
    if (!in_array(auth()->id(), [$message->sender_id, $message->receiver_id])) {
        abort(403, 'Unauthorized access');
    }
    
    if ($message->file_path) {
        $path = storage_path('app/public/' . $message->file_path);
        
        if (file_exists($path)) {
            // Mark as read if patient is downloading
            if ($message->receiver_id === auth()->id() && !$message->read_at) {
                $message->update(['read_at' => now()]);
            }
            
            $filename = 'prescription_' . $message->id . '_' . date('Y-m-d') . '.pdf';
            return response()->download($path, $filename);
        }
    }
    
    abort(404, 'File not found');
})->name('prescription.download')->middleware('auth');

// Download prescription by prescription ID
Route::get('/prescriptions/{prescription}/download', function ($prescriptionId) {
    $prescription = \App\Models\Prescription::with('patient')->findOrFail($prescriptionId);
    
    // Check if user has permission (use helper methods on User model)
    $user = auth()->user();
    $hasPermission = false;

    if (method_exists($user, 'isAdmin') && $user->isAdmin()) {
        $hasPermission = true;
    } elseif (method_exists($user, 'isDoctor') && $user->isDoctor() && $prescription->doctor_id === $user->id) {
        $hasPermission = true;
    } elseif (method_exists($user, 'isPatient') && $user->isPatient() && $prescription->patient_id === $user->id) {
        $hasPermission = true;
    }
    
    if (!$hasPermission) {
        abort(403, 'You do not have permission to download this prescription.');
    }
    
    if ($prescription->file_path) {
        $path = storage_path('app/public/' . $prescription->file_path);
        
        if (file_exists($path)) {
            $filename = 'prescription_' . $prescription->id . '_' . $prescription->patient->name . '_' . date('Y-m-d') . '.pdf';
            return response()->download($path, $filename);
        }
    }
    
    abort(404, 'Prescription file not found');
})->name('prescriptions.download')->middleware('auth');

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