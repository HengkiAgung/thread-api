<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\ThreadController;
// use App\Http\Controllers\CommentController;
// use App\Http\Controllers\AuthController;

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
    return response()->json(["status" => "success", "data" =>$request->user()], 200);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/threads', [ThreadController::class, 'getAll']);
    Route::get('/thread/{id}', [ThreadController::class, 'detailThread']);
    Route::post('/thread/create', [ThreadController::class, 'createThread']);
    Route::post('/thread/delete/{id}', [ThreadController::class, 'deleteThread']);

    // Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/comment/{thread}', [CommentController::class, 'commentOfThread']);
    Route::post('/comment/create', [CommentController::class, 'createComment']);

    Route::get('/comment/metion/me', [MentionController::class, 'getMentionedComment']);
    Route::post('/find/pepole', [MentionController::class , 'findUser']);
});
// 3|ccSixE4CCc1JsdTrdBC1nw9GAKGL8dUXGq5sZsdO
