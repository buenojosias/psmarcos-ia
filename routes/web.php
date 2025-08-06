<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/perfil', function () {
        return view('profile');
    })->name('profile');

    Route::get('/comunidades', App\Livewire\Communities\Index::class)->name('communities.index');
    Route::get('/comunidades/{community}', App\Livewire\Communities\Show::class)->name('communities.show');

    Route::get('/gmp', App\Livewire\Pastorals\Index::class)->name('pastorals.index');
});

require __DIR__.'/auth.php';
