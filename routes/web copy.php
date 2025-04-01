<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('tickets', TicketController::class);

// Authentication
Route::middleware(['guest'])->group(function () {
    Route::view('/login', 'auth.login')->name('login');

    Route::post('/register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'store'])
        ->name('register');

    Route::view('/register', 'auth.register')
        ->name('show-registration-form');

    Route::post('/logout', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
        ->name('dashboard');

    // Admin Panel
    Route::middleware(['admin'])->group(function () {
        Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])
            ->name('users');

        Route::get('/users/{user}/edit', [App\Http\Controllers\UserController::class, 'edit'])
            ->name('users.edit');

        Route::put('/users/{user}', [App\Http\Controllers\UserController::class, 'update'])
            ->name('users.update');

        Route::delete('/users/{user}', [App\Http\Controllers\UserController::class, 'destroy'])
            ->name('users.destroy');
    });

    Route::get('/ticket/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/ticket', [TicketController::class, 'store']);

    Route::get('/ticket/{ticket}', [TicketController::class, 'show'])->name('tickets.show');

    Route::post('/ticket/{ticket}/reply', [TicketController::class, 'reply'])->name('tickets.reply');
});

// Authentication
Route::get('/login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create'])
    ->name('login');

Route::get('/forgot-password', [App\Http\Controllers\PasswordResetLinkController::class, 'create'])
    ->name('password.request');

Route::post('/forgot-password', [App\Http\Controllers\PasswordResetLinkController::class, 'store'])
    ->name('password.email');

Route::get('/reset-password/{token}', [App\Http\Controllers\NewPasswordController::class, 'create'])
    ->name('password.reset');

Route::post('/reset-password', [App\Http\Controllers\NewPasswordController::class, 'store'])
    ->name('password.update');

Route::post('/logout', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

// Registration not enabled yet
/*
Route::get('/register', [App\Http\Controllers\RegisteredUserController::class, 'create'])
     ->middleware('guest')
     ->name('register');

Route::post('/register', [App\Http\Controllers\RegisteredUserController::class, 'store'])
     ->middleware('guest');*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::get('/tickets', function () {
//     return view('tickets');
// })->middleware(['auth', 'verified'])->name('tickets');

Route::get('/add-ticket', function () {
    return view('add-ticket');
})->middleware(['auth', 'verified'])->name('add-ticket');

Route::get('/chatbot', function () {
    return view('chatbot');
})->middleware(['auth', 'verified'])->name('chatbot');

// Route::get('/admindashboard', 'AdminController@dashboard')->name('admindashboard')->middleware('Administrator');
// Route::get('/dashboard', 'StudentController@dashboard')->name('dashboard')->middleware('Student');

Route::get('/admindashboard', function () {
    return view('admindashboard');
})->middleware(['auth', 'verified'])->name('admin_dashboard');

require __DIR__.'/auth.php';
