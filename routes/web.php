<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController;


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
    if (Auth::check()) {
        // If the user is authenticated, redirect them to the dashboard
        return redirect()->route('dashboard');
    }

    // If the user is not authenticated, show the login page
    return view('auth.login');
});
// Route for login form
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Route for login action (POST)
Route::post('/login', [AuthController::class, 'login']);

// Route for logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes (requires authentication)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [TaskController::class, 'dashboard'])->name('dashboard');
    Route::resource('tasks', TaskController::class);  // CRUD for tasks
    Route::patch('/tasks/{task}/update-status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
    Route::patch('tasks/{task}/assign', [TaskController::class, 'assignTask'])->name('tasks.assignTask');
    Route::patch('tasks/{task}/store-comment', [TaskController::class, 'storeComment'])->name('tasks.storeComment');
   Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
   Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store'); // Route for storing a new task
   Route::patch('tasks/{task}/store-comment', [TaskController::class, 'storeComment'])->name('tasks.storeComment');
});
