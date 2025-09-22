<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/cars', function () {
    return view('cars.index');
})->name('cars.index');

Route::get('/cars/{car:slug}', function (App\Models\Car $car) {
    $car->load(['make', 'model', 'attributes.attribute', 'reviews']);
    return view('cars.show', compact('car'));
})->name('cars.show');

Route::get('/legal/{page}', function (string $page) {
    $validPages = ['privacy-policy', 'terms-of-service', 'cookie-policy', 'refund-policy', 'shipping-policy'];

    if (!in_array($page, $validPages)) {
        abort(404);
    }

    return view('legal');
})->name('legal.show');


