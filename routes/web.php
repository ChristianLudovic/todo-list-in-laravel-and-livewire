<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialiteController;
use Illuminate\Support\Facades\Auth;

Route::middleware('guest')->group(function (){
    Route::get('/', function () {
        return view('index');
    })->name('index');
    Route::get('/login/{provider}', [SocialiteController::class, 'redirectToProvider'])->name('socialite.redirect');
    Route::get('/auth/{provider}/callback', [SocialiteController::class, 'handleProviderCallback']);
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth.custom'])->name('dashboard');

Route::post('/logout', [SocialiteController::class, 'logout'])->name('logout');
Auth::routes();
