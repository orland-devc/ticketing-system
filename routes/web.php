<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SignUpRequestController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataBankController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\InfoBankController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\MISController;
use App\Http\Controllers\OFficeTicketController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketCategoryController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Models\Attachment;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

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
    return view('landing');
});

Route::get('/officedashboard', function () {
    return view('officedashboard');
})->middleware(['auth', 'verified'])->name('officedashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/admindashboard', [DashboardController::class, 'dashboard'])->name('admindashboard');

});

Route::resource('tickets', TicketController::class)->middleware(['auth', 'verified']);

Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('ticket.show')->middleware(['auth', 'verified']);

Route::get('/chatbot', function () {
    return view('chatbot');
})->middleware(['auth', 'verified'])->name('chatbot');

Route::get('/admin-add-ticket', function () {
    return view('profile.admin-add-ticket');
})->middleware(['auth', 'verified'])->name('admin-add-ticket');

Route::get('/tickets/{ticket}/assign', [TicketController::class, 'showAssignForm']);
Route::post('/tickets/{ticket}/assign', [TicketController::class, 'assignTicket'])->name('tickets.assign');

Route::get('/assigned-tickets', [TicketController::class, 'getAssignedTickets'])->name('assigned-tickets');

Route::resource('manage-chatbot', FaqController::class);

Route::post('/api/chatbot', [ChatbotController::class, 'handleMessage']);

Route::get('/user-management', [TicketController::class, 'addUser'])->middleware(['auth', 'verified'])->name('manage.users');

Route::resource('users', UserController::class)->middleware(['auth', 'verified']);

Route::get('users/create', function () {
    return view('add-user');
})->middleware(['auth', 'verified'])->name('add-user');

Route::post('/users', [UserController::class, 'store'])->name('users.store');

Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');

Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');
// routes/web.php

Route::get('/unavailable', function () {
    return view('unavailable');
})->name('unavailable');

Route::middleware(['auth'])->group(function () {
    Route::get('/assigned-tickets/{ticket}', [OfficeTicketController::class, 'show'])->name('office.tickets.show');
    // Route::get('/assigned-tickets', [OfficeTicketController::class, 'show'])->name('office.tickets');

    Route::get('/office/tickets/{ticket}/updates', [TicketController::class, 'fetchUpdates'])->name('office.tickets.updates');
    Route::get('/office/tickets/{ticket}/replies', [TicketController::class, 'fetchReplies'])->name('office.tickets.replies');
    Route::post('/office/tickets/{ticket}/reply', [TicketController::class, 'submitReply'])->name('office.tickets.reply');

    Route::get('/my-tickets/{ticket:ticket_code}', [OfficeTicketController::class, 'showUserTicketDetails'])->name('user.tickets.show');
    Route::get('/my-tickets', [TicketController::class, 'userIndex'])->name('my-tickets');

});

// web.php
Route::post('/tickets/{ticket}/return', [TicketController::class, 'unread'])->name('tickets.returnToQueue');

Route::get('/ai.psu', [ChatbotController::class, 'chatbot']);

Route::get('login/google', [LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('callback/google', [LoginController::class, 'handleGoogleCallback'])->name('callback.google');

Route::middleware(['auth'])->group(function () {
    Route::get('/messages', [MessagesController::class, 'index'])->name('messages.index');
    Route::get('/dashboard', [MessagesController::class, 'dashboard'])->name('dashboard');

    Route::get('/chats/{chatId}/messages', [MessagesController::class, 'getMessages'])->name('chats.messages');
    Route::post('/chats/message', [MessagesController::class, 'sendMessage'])->name('chats.sendMessage');
    Route::get('/latest-chats', [MessagesController::class, 'getLatestChats']);
    Route::get('/search-users', [MessagesController::class, 'searchUsers']);
    Route::post('/chats/get-or-create/{userId}', [MessagesController::class, 'getOrCreateChat']);
    Route::post('/chats/start-new-chat', [MessagesController::class, 'startNewChat']);

});

Route::get('uploads/{filename}', function ($filename) {
    $path = public_path('uploads/'.$filename);
    if (! Attachment::exists($path)) {
        abort(404);
    }

    return response()->file($path);
})->where('filename', '.*');

Route::get('/account', function () {
    return view('profile.profile-page');
});

Route::get('/guest', function () {
    return view('unavailable');
});

Route::get('/verify', function () {
    return view('tickets.guest.guest-ticket-track');
});

// Route::post('/tickets/guest', [TicketController::class, 'storeGuestTicket'])->name('tickets.guest.store');
// Route::post('/tickets/track', [TicketController::class, 'trackGuestTicket'])->name('tickets.guest.track');

Route::post('/tickets/guest/store', [TicketController::class, 'storeGuestTicket'])->name('tickets.guest.store');
Route::post('/tickets/guest/verify', [TicketController::class, 'verifyGuestTicket'])->name('tickets.guest.verify');

Route::get('/chatbot2', [ChatbotController::class, 'chatbot']);

Route::get('data_bank', [DataBankController::class, 'create'])->name('data_bank.create');
Route::post('data_bank/store', [DataBankController::class, 'store'])->name('data_bank.store');

Route::post('data_bank/databank-update/{id}', [DataBankController::class, 'dataBankUpdate'])->name('dashboard.update');

Route::post('chatbot/update-info', [DataBankController::class, 'infoUpdate'])->name('dashboard.updateAll');

Route::post('/chatbot/message', [ChatbotController::class, 'processMessage']);

Route::post('data_bank/name-update', [DataBankController::class, 'nameUpdate'])->name('dashboard.nameupdate');
Route::post('data_bank/greet-update', [DataBankController::class, 'greetUpdate'])->name('dashboard.greetupdate');
Route::post('data_bank/fallback-update', [DataBankController::class, 'fallbackUpdate'])->name('dashboard.fallbackupdate');
Route::post('data_bank/repeated-update', [DataBankController::class, 'repeatedUpdate'])->name('dashboard.repeatupdate');

Route::get('/tickets/{id}', [TicketController::class, 'show'])->name('tickets.show');
Route::post('/tickets/{id}/reply', [TicketController::class, 'reply'])->name('tickets.reply');

Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('login', [AuthenticatedSessionController::class, 'store']);

Route::get('/login/student', [AuthenticatedSessionController::class, 'createStudent'])->name('login.student');
Route::post('/login/student', [AuthenticatedSessionController::class, 'store'])->name('login.student.store');

Route::get('signup', [SignUpRequestController::class, 'create']);
Route::post('signup', [SignUpRequestController::class, 'store'])->name('signup.request');

Route::middleware(['auth'])->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('mis/requests', [MISController::class, 'index'])->name('mis.requests');
    Route::post('mis/requests/{request}/approve', [MISController::class, 'approve'])->name('mis.requests.approve');
    Route::post('mis/requests/{request}/reject', [MISController::class, 'reject'])->name('mis.requests.reject');

    Route::get('/ticket-category/create', [TicketCategoryController::class, 'create'])->name('ticket_category.create');
    Route::post('/ticket-category', [TicketCategoryController::class, 'store'])->name('ticket_category.store');
    Route::delete('/ticket-category/{id}', [TicketCategoryController::class, 'destroy'])->name('ticket_category.destroy');
    Route::get('/ticket-category/{id}/edit', [TicketCategoryController::class, 'edit'])->name('ticket_category.edit');

    Route::get('try-react', [UserController::class, 'unavailable'])->name('try-react');

    Route::get('send-email', [EmailController::class, 'sendWelcomeEmail']);

    Route::get('/contact-support', function () {
        return view('support.contact'); // Create this view if it doesn't exist
    })->name('contact.support');

    Route::resource('info-bank', InfoBankController::class)->middleware('auth');

});

Route::post('/office/tickets/ai-suggestion', [App\Http\Controllers\TicketController::class, 'generateAISuggestion'])
    ->name('office.tickets.ai-suggestion');

require __DIR__.'/auth.php';
