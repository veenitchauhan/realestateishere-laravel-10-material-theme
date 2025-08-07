<?php

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

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;


Route::get('/', function () {
	return redirect('sign-in');
})->middleware('guest');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('sign-up', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('sign-up', [RegisterController::class, 'store'])->middleware('guest');
Route::get('sign-in', [SessionsController::class, 'create'])->middleware('guest')->name('login');
Route::post('sign-in', [SessionsController::class, 'store'])->middleware('guest');
Route::post('verify', [SessionsController::class, 'show'])->middleware('guest');
Route::post('reset-password', [SessionsController::class, 'update'])->middleware('guest')->name('password.update');
Route::get('verify', function () {
	return view('sessions.password.verify');
})->middleware('guest')->name('verify');
Route::get('/reset-password/{token}', function ($token) {
	return view('sessions.password.reset', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('sign-out', [SessionsController::class, 'destroy'])->middleware('auth')->name('logout');
Route::get('profile', [ProfileController::class, 'create'])->middleware('auth')->name('profile');
Route::get('user-profile', [ProfileController::class, 'create'])->middleware('auth')->name('user-profile');
Route::post('user-profile', [ProfileController::class, 'update'])->middleware('auth');
Route::group(['middleware' => 'auth'], function () {
	Route::get('/home', [DashboardController::class, 'index'])->name('home');

	// 🔒 PERMISSION-BASED ACCESS CONTROL - Real Granular Control! 🔒
	
	// Permissions Management - Super Admin only (can manage all permissions)
	Route::resource('permissions', App\Http\Controllers\ACL\PermissionController::class)
		->middleware(['permission:view-permissions']);
		
	// Roles Management - Super Admin and Admin (but with different capabilities)
	Route::resource('roles', App\Http\Controllers\ACL\RoleController::class)
		->middleware(['permission:view-roles']);
		
	// Users Management - Hierarchical permissions
	Route::resource('users', App\Http\Controllers\UserController::class)
		->middleware(['permission:view-users']);
	
	// User Impersonation - Super Admin only
	Route::post('users/{user}/impersonate', [App\Http\Controllers\UserController::class, 'impersonate'])
		->middleware(['auth', 'role:Super Admin'])
		->name('users.impersonate');
	
	Route::get('stop-impersonating', [App\Http\Controllers\UserController::class, 'stopImpersonating'])
		->middleware('auth')
		->name('stop-impersonating');

	// Properties Management - Real Estate Core Functionality
	Route::resource('properties', App\Http\Controllers\PropertyController::class)
		->middleware(['permission:show-property']);
	
	// Reports - For users with reporting permissions
	Route::get('/reports', [App\Http\Controllers\ReportsController::class, 'index'])
		->middleware('permission:view-reports')->name('reports');
});
