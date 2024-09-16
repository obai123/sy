<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Category
Route::get('/getAllParenteCategories', [CategoryController::class, 'index']);
Route::get('/getCategoryById/{id}', [CategoryController::class, 'show']);
Route::post('/createCategory', [CategoryController::class, 'store']);
Route::post('/updateCategory', [CategoryController::class, 'update']);
Route::delete('/deleteCategory/{id}', [CategoryController::class, 'destroy']);



// File
Route::post('/files/upload', [FileController::class, 'upload']);
Route::delete('/files/{id}', [FileController::class, 'delete']);
Route::get('/files/display/{id}', [FileController::class, 'display']);
Route::get('/files/download/{id}', [FileController::class, 'download']);

