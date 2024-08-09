<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Admin auth route
Route::get('/admin/login',[AdminController::class,'admin_login'])->name('admin.login');

// Admin routes
Route::middleware(['auth','isrole:admin'])->prefix('admin')->group(function (){
    Route::get('/dashboard',[AdminController::class,'index']);
    Route::get('/logout',[AdminController::class,'destroy'])->name('admin.logout');

    // profile 
    Route::get("profile",[AdminController::class,'profile'])->name('admin.profile');
    Route::post("profile",[AdminController::class,'update_profile'])->name('admin.update.profile');

    // change password
    Route::get("update-password",[AdminController::class,'update_password'])->name('admin.password');
    Route::post("update-password",[AdminController::class,'update_password'])->name('admin.password');
});

// Agent routes
Route::middleware(['auth','isrole:agent'])->group(function (){
    Route::get('agent/dashboard',[AgentController::class,'index']);
});
