<?php

use Illuminate\Support\Facades\Route;

// Route::view('/', 'welcome');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/perfil', function () {
        return view('profile');
    })->name('profile');

    Route::get('/usuarios', App\Livewire\Users\Index::class)->name('users.index');
    Route::get('/usuarios/{user}', App\Livewire\Users\Show::class)->name('users.show');

    Route::get('/comunidades', App\Livewire\Communities\Index::class)->name('communities.index');
    Route::get('/comunidades/{community}', App\Livewire\Communities\Show::class)->name('communities.show');

    Route::get('/gmp', App\Livewire\Pastorals\Index::class)->name('pastorals.index');
    Route::get('/gmp/{pastoral}', App\Livewire\Pastorals\Show::class)->name('pastorals.show');
});

require __DIR__.'/auth.php';
