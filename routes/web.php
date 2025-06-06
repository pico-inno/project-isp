<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', \App\Livewire\Dashboard::class)->middleware(['auth', 'verified'])->name('dashboard')->lazy();

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/about', \App\Livewire\About::class)->middleware(['auth', 'verified'])->name('about')->lazy();


    Route::get('/users', \App\Livewire\User\Index::class)->name('users.index')->lazy()->middleware('permission:read,User');
    Route::get('/users/create', \App\Livewire\User\Form::class)->name('users.create')->lazy()->middleware('permission:create,User');
    Route::get('/users/{user}/edit', \App\Livewire\User\Form::class)->name('users.edit')->lazy()->middleware('permission:update,User');

    Route::get('/role-permissions', \App\Livewire\Role\Index::class)->name('role-permissions.index')->lazy()->middleware('permission:read,Role');
    Route::get('/role-permissions/create', \App\Livewire\Role\Form::class)->name('role-permissions.create')->lazy()->middleware('permission:create,Role');
    Route::get('/role-permissions/{role}/edit', \App\Livewire\Role\Form::class)->name('role-permissions.edit')->lazy()->middleware('permission:update,Role');


    Route::prefix('routers')->group(function () {
        Route::get('/', \App\Livewire\Router\Index::class)->name('routers.index')->lazy()->middleware('permission:read,Router');
        Route::get('/create', \App\Livewire\Router\Form::class)->name('routers.create')->lazy()->middleware('permission:create,Router');
        Route::get('/{router}/edit', \App\Livewire\Router\Form::class)->name('routers.edit')->lazy()->middleware('permission:update,Router');
        Route::get('/{router}/dashboard', \App\Livewire\Router\Dashboard::class)->name('routers.dashboard')->lazy()->middleware('permission:read,Router');
    });

    Route::get('/{router}/profiles', \App\Livewire\PppProfile\Index::class)->name('ppp_profiles.index')->lazy()->middleware('permission:read,Router');
    Route::get('/{router}/profiles/create', \App\Livewire\PppProfile\Form::class)->name('ppp_profiles.create')->lazy()->middleware('permission:create,Router');
    Route::get('/{router}/profiles/{pppProfile}/edit', \App\Livewire\PppProfile\Form::class)->name('ppp_profiles.edit')->lazy()->middleware('permission:update,Router');

        Route::get('/{router}/radius', \App\Livewire\Radius\Index::class)->name('radius.index')->lazy()->middleware('permission:read,Router');
        Route::get('/{router}/radius/create', \App\Livewire\Radius\Form::class)->name('radius.create')->lazy()->middleware('permission:create,Router');
        Route::get('/{router}/radius/{id}/edit', \App\Livewire\Radius\Form::class)->name('radius.edit')->lazy()->middleware('permission:update,Router');

    Route::get('/{router}/radcheck', \App\Livewire\RadCheck\Index::class)->name('radcheck.index')->lazy()->middleware('permission:read,Router');
    Route::get('/{router}/radcheck/create', \App\Livewire\RadCheck\Form::class)->name('radcheck.create')->lazy()->middleware('permission:create,Router');
    Route::get('/{router}/radcheck/{radCheck}/edit', \App\Livewire\RadCheck\Form::class)->name('radcheck.edit')->lazy()->middleware('permission:update,Router');

});

require __DIR__.'/auth.php';
