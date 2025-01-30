<?php

use App\Http\Controllers\Api\Project\CreateAction;
use App\Http\Controllers\Api\Project\ExportController;
use App\Http\Controllers\Api\Project\ListAction;
use App\Http\Controllers\Api\ProjectDetails\CreateAction as ProjectDetailsCreateAction;
use App\Http\Controllers\Api\ProjectDetails\GetCompletedDetailsAction;
use App\Http\Controllers\Api\ProjectDetails\GetLatestProjectDetailAction;
use App\Http\Controllers\Api\ProjectDetails\UpdateAction as ProjectDetailsUpdateAction;
use Illuminate\Support\Facades\Route;

Route::get('/projects', ListAction::class);
Route::post('/projects/create', CreateAction::class);
Route::post('/projects/{id}/details/create', ProjectDetailsCreateAction::class);
Route::patch('/projects/{projectId}/details/update/{id}', ProjectDetailsUpdateAction::class);
Route::get('/projects/{projectId}/details/latest', GetLatestProjectDetailAction::class);
Route::get('/projects/{projectId}/details/completed', GetCompletedDetailsAction::class);
Route::get('/export-closed-project', ExportController::class)->name('exportClosedProject');
