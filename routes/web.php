<?php

use Illuminate\Support\Facades\Route;

// Route::view('/', 'welcome');
Route::get('testes', App\Http\Controllers\TestsController::class);

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/perfil', function () {
        return view('profile');
    })->name('profile');

    Route::get('/comunidades', App\Livewire\Communities\Index::class)->name('communities.index');
    Route::get('/comunidades/{community}', App\Livewire\Communities\Show::class)->name('communities.show');
    Route::get('/comunidades/{community}/eventos', App\Livewire\Communities\Events::class)->name('communities.events');
    Route::get('/comunidades/{community}/grupos', App\Livewire\Communities\Pastorals::class)->name('communities.pastorals');
    Route::get('/comunidades/{community}/perguntas', App\Livewire\Communities\Questions::class)->name('communities.questions');

    Route::get('/gmp', App\Livewire\Pastorals\Index::class)->name('pastorals.index');
    Route::get('/gmp/{pastoral}', App\Livewire\Pastorals\Show::class)->name('pastorals.show');
    Route::get('/gmp/{pastoral}/eventos', App\Livewire\Pastorals\Events::class)->name('pastorals.events');
    Route::get('/gmp/{pastoral}/perguntas', App\Livewire\Pastorals\Questions::class)->name('pastorals.questions');

    Route::get('/eventos', App\Livewire\Events\Index::class)->name('events.index');
    Route::get('/eventos/{event}', App\Livewire\Events\Show::class)->name('events.show');
    Route::get('/eventos/{event}/perguntas', App\Livewire\Events\Questions::class)->name('events.questions');

    Route::get('/missas', App\Livewire\Masses\Index::class)->name('masses.index');

    Route::get('/perguntas', App\Livewire\Questions\Index::class)->name('questions.index')->middleware(['role:admin|pascom']);
    Route::get('/perguntas/sugestoes', App\Livewire\Questions\ListSuggestions::class)->name('questions.suggestions')->middleware(['role:admin|pascom']);

    Route::get('/avisos', App\Livewire\Notices\Index::class)->name('notices.index');

    Route::get('/usuarios', App\Livewire\Users\Index::class)->name('users.index')->middleware(['role:admin|pascom']);
    Route::get('/usuarios/{user}', App\Livewire\Users\Show::class)->name('users.show');

});

require __DIR__ . '/auth.php';
