<?php

namespace App\Http\Controllers\Api\ProjectDetails;

use App\Http\Controllers\Controller;
use App\Models\Projects;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetLatestProjectDetailAction extends Controller
{
    public function __invoke(Request $request, int $projectId): JsonResponse
    {
        $project = Projects::find($projectId);

        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        $latestDetail = $project->projectDetails()->latest('created_at')->first();

        if (!$latestDetail) {
            return response()->json(null);
        }
        return response()->json($latestDetail);
    }
}
