<?php 
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('api/users', [UserController::class, 'index']); // Get all posts
Route::post('api/users', [UserController::class, 'store']); // Create a new post
Route::get('api/users/{id}', [UserController::class, 'show']); // Get a single post
