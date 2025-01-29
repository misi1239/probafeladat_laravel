<?php

use App\Http\Controllers\Api\Project\ShowAction;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/{pathMatch}', function () {
    return view('welcome');
})->where("pathMatch", ".*");
