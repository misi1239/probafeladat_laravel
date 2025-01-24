<?php

namespace App\Http\Controllers\Api\Project;

use App\Http\Controllers\Controller;
use App\Models\Projects;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListAction extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        return response()->json(Projects::all());
    }
}
