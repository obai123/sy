<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });


// Category
Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/getCategoryById/{id}', [CategoryController::class, 'show'])->name('categories.show');
Route::post('/createCategory', [CategoryController::class, 'store'])->name('categories.store');
Route::post('/updateCategory', [CategoryController::class, 'update'])->name('categories.edit');
Route::delete('/deleteCategory/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');



// File
Route::post('/files/upload', [FileController::class, 'upload'])->name('file.upload');
Route::delete('/files/{id}', [FileController::class, 'delete'])->name('file.delete');
Route::get('/files/display/{id}', [FileController::class, 'display'])->name('file.display');
Route::get('/files/download/{id}', [FileController::class, 'download'])->name('file.download');



require __DIR__ . '/auth.php';
