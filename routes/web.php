<?php
use App\Http\Controllers\ProductApiController;
use Illuminate\Http\Request;
use App\Livewire\CustomLogin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Patient\PatientDashboard;
use App\Livewire\Patient\SymptomChecker;
use App\Livewire\Patient\Appointments  ;
use App\Livewire\Patient\Chat;
use App\Livewire\Patient\Wallet;
use App\Livewire\Patient\Pharmacy;
use App\Livewire\Doctor\DoctorDashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes
Route::get('/', CustomLogin::class)->name('welcome')->middleware('guest');

// Custom logout route
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Routes that require authentication
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    
    // Profile route - accessible to all authenticated users
    Route::get('/user/profile', function () {
        return view('profile.show');
    })->name('profile.show');
    
    // Settings route - accessible to all authenticated users
    
    

    // !! Admin routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', AdminDashboard::class)->name('dashboard');

    });
   
    //!! Staff routes - All admin routes available to staff (permissions control access)
    Route::middleware('role:patient')->prefix('patient')->name('patient.')->group(function () {
        // Dashboard
        Route::get('/dashboard', PatientDashboard::class)->name('dashboard');
        Route::get('/symptom-checker', SymptomChecker::class)->name('symptom-checker');
        Route::get('/appointments', Appointments::class)->name('appointments');
        Route::get('/chat', Chat::class)->name('chat');
        Route::get('/wallet', Wallet::class)->name('wallet');
        Route::get('/pharmacy', Pharmacy::class)->name('pharmacy');

    
        

    });

    Route::middleware('role:doctor')->prefix('doctor')->name('doctor.')->group(function () {
        Route::get('/dashboard', DoctorDashboard::class)->name('dashboard');

    });

});