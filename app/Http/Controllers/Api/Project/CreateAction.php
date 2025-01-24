<?php

namespace App\Http\Controllers\Api\Project;

use App\Http\Controllers\Controller;
use App\Models\Projects;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

class CreateAction extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:50',
            ]);

            $project = Projects::create([
                'name' => $validated['name'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Project created successfully.',
                'data' => $project,
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create project.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
