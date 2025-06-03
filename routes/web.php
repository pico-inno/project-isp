<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', \App\Livewire\Dashboard::class)->middleware(['auth', 'verified'])->name('dashboard')->lazy();

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/users', \App\Livewire\User\Index::class)->name('users.index')->middleware('permission:read,User');
    Route::get('/users/create', \App\Livewire\User\Form::class)->name('users.create')->middleware('permission:create,User');
    Route::get('/users/{user}/edit', \App\Livewire\User\Form::class)->name('users.edit')->middleware('permission:update,User');

    Route::get('/role-permissions', \App\Livewire\Role\Index::class)->name('role-permissions.index')->middleware('permission:read,Role');
    Route::get('/role-permissions/create', \App\Livewire\Role\Form::class)->name('role-permissions.create')->middleware('permission:create,Role');
    Route::get('/role-permissions/{role}/edit', \App\Livewire\Role\Form::class)->name('role-permissions.edit')->middleware('permission:update,Role');

});

require __DIR__.'/auth.php';
