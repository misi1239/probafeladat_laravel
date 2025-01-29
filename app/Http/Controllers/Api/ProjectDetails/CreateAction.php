<?php

namespace App\Http\Controllers\Api\ProjectDetails;

use App\Http\Controllers\Controller;
use App\Models\Projects;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreateAction extends Controller
{
    public function __invoke(Request $request, int $id): JsonResponse
    {
        $project = Projects::find($id);

        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        $validated = $request->validate([
            'start' => 'nullable|date',
            'finish' => 'nullable|date',
            'note' => 'nullable|string',
            'isStarted' => 'nullable|boolean',
            'isStopped' => 'nullable|boolean',
            'isCompleted' => 'nullable|boolean',
        ]);

        $projectDetails = $project->projectDetails()->create($validated);

        return response()->json($projectDetails);
    }
}
