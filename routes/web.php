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
    Route::resource('posts', PostController::class)->middleware('auth');
});

require __DIR__.'/auth.php';
