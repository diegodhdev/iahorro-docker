<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {

});

Route::get('/lead/create', \App\Http\Controllers\Leads\CreateController::class)->name('lead.create');
Route::get('/lead/edit/{id}', \App\Http\Controllers\Leads\EditController::class)->name('lead.edit');
Route::get('/lead/show/{id}', \App\Http\Controllers\Leads\ShowController::class)->name('lead.show');

Route::put('/lead/store', \App\Http\Controllers\Leads\StoreController::class)->name('lead.store');
Route::patch('/lead/update', \App\Http\Controllers\Leads\UpdateController::class)->name('lead.update');
Route::get('/lead/destroy/{id}', \App\Http\Controllers\Leads\DestroyController::class)->name('lead.destroy');


