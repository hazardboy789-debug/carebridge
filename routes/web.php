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
use App\Livewire\Landing\IndexPage;
use App\Livewire\Landing\AboutPage;
use App\Livewire\Landing\ServicesPage;
use App\Livewire\Landing\DoctorPage;
use App\Livewire\Landing\ContactPage;
use App\Livewire\Landing\ApointmentPage;
use App\Http\Controllers\RegisterController;
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
Route::get('/login', CustomLogin::class)->name('login')->middleware('guest');
Route::post('/register', [RegisterController::class, 'register'])->name('register')->middleware('guest');

//Landing page routes
Route::get('/', IndexPage::class)->name('welcome');
Route::get('/about', AboutPage::class)->name('about')->middleware('guest');
Route::get('/services', ServicesPage::class)->name('services')->middleware('guest');
Route::get('/doctors', DoctorPage::class)->name('doctors')->middleware('guest');
Route::get('/contact', ContactPage::class)->name('contact')->middleware('guest');
Route::get('/appointment', ApointmentPage::class)->name('appointment')->middleware('guest');




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