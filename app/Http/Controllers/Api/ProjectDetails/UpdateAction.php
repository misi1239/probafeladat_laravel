<?php

namespace App\Http\Controllers\Api\ProjectDetails;

use App\Http\Controllers\Controller;
use App\Models\Projects;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UpdateAction extends Controller
{
    public function __invoke(Request $request, int $projectId, int $id): JsonResponse
    {
        $project = Projects::find($projectId);

        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        $projectDetails = $project->projectDetails()->find($id);

        if (!$projectDetails) {
            return response()->json(['message' => 'Project details not found'], 404);
        }

        $validationResponse = $this->validateUpdateConditions($request, $projectDetails);
        if ($validationResponse) {
            return $validationResponse;
        }

        $validated = $request->validate([
            'start' => 'nullable|date',
            'finish' => 'nullable|date',
            'note' => 'nullable|string',
            'isStarted' => 'nullable|boolean',
            'isStopped' => 'nullable|boolean',
            'isCompleted' => 'nullable|boolean',
        ]);

        $projectDetails->update($validated);

        return response()->json($projectDetails);
    }

    private function validateUpdateConditions(Request $request, $projectDetails): ?JsonResponse
    {
        if ($projectDetails->isStarted && $request->has('start')) {
            return response()->json(['message' => 'Start time cannot be modified once started'], 400);
        }

        if ($projectDetails->isStopped && $request->has('finish')) {
            return response()->json(['message' => 'Finish time cannot be modified once stopped'], 400);
        }

        if ($projectDetails->isCompleted && $request->has('isCompleted')) {
            return response()->json(['message' => 'Completed status cannot be modified once completed'], 400);
        }

        return null;
    }
}
