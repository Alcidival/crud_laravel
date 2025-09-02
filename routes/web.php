<?php

use App\Http\Controllers\CursoController;
use App\Models\Curso;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('curso',CursoController::class);
