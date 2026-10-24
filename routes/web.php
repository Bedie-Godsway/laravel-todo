<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', [PageController::class, 'hello']);

// My Todo Routes
Route::get('/todos', [TodoController::class, 'index']);
Route::post('/todos', [TodoController::class, 'store']);
Route::patch('/todos/{todo}', [TodoController::class, 'update']);
Route::delete('/todos/{todo}', [TodoController::class, 'destroy']);

Route::get('/todos/{todo}/edit', [TodoController::class, 'edit'])->name('todos.edit');

Route::get('/dashboard', [TodoController::class, 'dashboardPage']);
Route::get('/settings', [TodoController::class, 'settingsPage']);
Route::get('/footer', [TodoController::class, 'footerPage']);

// middleware group for authenticated and verified users
Route::middleware(['auth', 'verified.custom'])->group(function(){
    Route::get('/profile', [TodoController::class, 'profilePage']);
    Route::get('/profile/updatePassword', [AuthController::class, 'showUpdatePassword']);
    Route::post('/profile/updatePassword', [AuthController::class, 'updatePassword']);
    Route::post('/profile', [AuthController::class, 'updateProfile']);
});


Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout']);


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/resend', [AuthController::class, 'resendVerification'])->middleware(['auth']);
