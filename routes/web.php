<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/clients', function () {
    return view('clients.index');
})->name('clients.index');

Route::get('/cities', function () {
    return view('cities.index');
})->name('cities.index');

Route::get('/representatives', function () {
    return view('representatives.index');
})->name('representatives.index');
