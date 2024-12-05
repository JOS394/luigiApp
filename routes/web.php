<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('calendar');
});

Route::get('/calendar', function () {
    return view('calendar');
})->middleware(['auth', 'verified'])->name('calendar');

Route::post('/calendar/add-amount', [CalendarController::class, 'addAmount'])->name('calendar.addAmount');
Route::get('/calendar/get-events', [CalendarController::class, 'getEvents'])->name('calendar.getEvents');
Route::post('/calendar/update-amount/', [CalendarController::class, 'updateAmount'])->name('calendar.updateAmount');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
