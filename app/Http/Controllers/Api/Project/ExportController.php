<?php

namespace App\Http\Controllers\Api\Project;

use App\Exports\CloseTrackingProjectsExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportController extends Controller
{
    public function __invoke(): BinaryFileResponse
    {
        return Excel::download(new CloseTrackingProjectsExport(), 'closed-projects.xlsx');
    }
}
