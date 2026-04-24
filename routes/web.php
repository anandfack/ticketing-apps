<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\TicketController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

Route::middleware(['auth'])->group(function () {

    Route::get('/tickets', [TicketController::class, 'index']);

    Route::get('/tickets/create', [TicketController::class, 'create']);
    Route::post('/tickets', [TicketController::class, 'store']);

    Route::get('/tickets/{ticket}', [TicketController::class, 'show']);

    Route::put('/tickets/{ticket}', [TicketController::class, 'update']);

    Route::post('/tickets/{ticket}/assign', [TicketController::class, 'assign']);

    Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy']);
});
