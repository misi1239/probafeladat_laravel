<?php

use App\Http\Controllers\Api\Project\CreateAction;
use App\Http\Controllers\Api\Project\ListAction;
use Illuminate\Support\Facades\Route;

Route::get('/projects', ListAction::class);
Route::post('/projects/create', CreateAction::class);

