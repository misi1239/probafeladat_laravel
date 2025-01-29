<?php

use App\Http\Controllers\Api\Project\CreateAction;
use App\Http\Controllers\Api\Project\ListAction;
use App\Http\Controllers\Api\Project\ShowAction;
use App\Http\Controllers\Api\ProjectDetails\CreateAction as ProjectDetailsCreateAction;
use App\Http\Controllers\Api\ProjectDetails\UpdateAction as ProjectDetailsUpdateAction;
use App\Http\Controllers\Api\ProjectDetails\ShowAction as ProjectDetailsShowAction;
use App\Http\Controllers\Api\ProjectDetails\GetLatestProjectDetailAction;
use App\Http\Controllers\Api\ProjectDetails\GetCompletedDetailsAction;
use Illuminate\Support\Facades\Route;

Route::get('/projects', ListAction::class);
Route::get('/projects/{id}', ShowAction::class);
Route::get('/projects/{id}/details', ProjectDetailsShowAction::class);
Route::post('/projects/create', CreateAction::class);
Route::post('/projects/{id}/details/create', ProjectDetailsCreateAction::class);
Route::patch('/projects/{projectId}/details/update/{id}', ProjectDetailsUpdateAction::class);
Route::get('/projects/{projectId}/details/latest', GetLatestProjectDetailAction::class);
Route::get('/projects/{projectId}/details/completed', GetCompletedDetailsAction::class);
