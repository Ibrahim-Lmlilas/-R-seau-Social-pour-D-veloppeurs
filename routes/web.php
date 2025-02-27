<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use Illuminate\Support\Facades\Auth;

Route::get('/dashboard', function () {
    $user = Auth::user();
    return view('dashboard', compact('user'));
})->middleware(['auth', 'verified'])->name('dashboard');


use App\Http\Controllers\ConnectionController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/connections/{user}', [ConnectionController::class, 'sendConnectionRequest'])->name('connections.send');
    Route::post('/connections/{user}/accept', [ConnectionController::class, 'acceptConnectionRequest'])->name('connections.accept');
    Route::post('/connections/{user}/reject', [ConnectionController::class, 'rejectConnectionRequest'])->name('connections.reject');
    Route::get('/connections', [ConnectionController::class, 'getConnections'])->name('connections.index');

    Route::get('/posts/create/line', [PostController::class, 'createLine'])->name('posts.createLine');
    Route::post('/posts/store/line', [PostController::class, 'storeLine'])->name('posts.storeLine');

    Route::get('/posts/create/code', [PostController::class, 'createCode'])->name('posts.createCode');
    Route::post('/posts/store/code', [PostController::class, 'storeCode'])->name('posts.storeCode');

    Route::get('/posts/create/image', [PostController::class, 'createImage'])->name('posts.createImage');
    Route::post('/posts/store/image', [PostController::class, 'storeImage'])->name('posts.storeImage');

});

require __DIR__ . '/auth.php';
