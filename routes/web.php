<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('events.index'));

Route::resource('events', EventController::class);

// Publieke inschrijfflow
Route::get('events/{event}/reserveren', [ReservationController::class, 'create'])
    ->name('reservations.create');
Route::post('events/{event}/reserveren', [ReservationController::class, 'store'])
    ->name('reservations.store');

// Admin dashboard met reservaties per event
Route::get('events/{event}/reservations', [ReservationController::class, 'index'])
    ->name('reservations.index');

// Betaling markeren
Route::patch('reservations/{reservation}/mark-paid', [ReservationController::class, 'markPaid'])
    ->name('reservations.mark-paid');