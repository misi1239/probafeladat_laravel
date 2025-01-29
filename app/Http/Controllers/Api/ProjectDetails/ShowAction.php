<?php

namespace App\Http\Controllers\Api\ProjectDetails;

use App\Http\Controllers\Controller;
use App\Models\Projects;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShowAction extends Controller
{
    public function __invoke(Request $request, int $id): JsonResponse
    {
        $project = Projects::find($id);

        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        $projectDetails = $project->projectDetails;

        if (!$projectDetails) {
            return response()->json(['message' => 'Project details not found'], 404);
        }

        return response()->json($projectDetails);
    }

}
