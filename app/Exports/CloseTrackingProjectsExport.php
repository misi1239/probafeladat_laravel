<?php

namespace App\Exports;

use App\Models\Projects;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class CloseTrackingProjectsExport implements FromCollection, WithHeadings
{
    /**
     * @return Collection
     */
    public function collection(): Collection
    {
        $projects = Projects::with('projectDetails')->get();

        $data = [];

        $minDate = null;
        $maxDate = null;

        foreach ($projects as $project) {
            $totalDuration = $this->calculateProjectDuration($project);

            $data[] = ['Project' => $project->name, 'Duration' => $totalDuration];

            foreach ($project->projectDetails as $detail) {
                if ($detail->start) {
                    $startDate = Carbon::parse($detail->start)->startOfDay();
                    $minDate = $minDate ? min($minDate, $startDate) : $startDate;
                }
                if ($detail->finish) {
                    $finishDate = Carbon::parse($detail->finish)->startOfDay();
                    $maxDate = $maxDate ? max($maxDate, $finishDate) : $finishDate;
                }
            }
        }

        $dateRange = $minDate && $maxDate
            ? $minDate->format('Y-m-d') . ' - ' . $maxDate->format('Y-m-d')
            : 'N/A';

        $data[] = [
            'Project', 'Start', 'Finish', 'Duration', 'Memo', 'Date Range: '
            . $dateRange . ' | Exported At: ' . Carbon::now()->format('Y-m-d H:i:s')
        ];

        foreach ($projects as $project) {
            foreach ($project->projectDetails as $detail) {
                $data[] = [
                    'Project' => $project->name,
                    'Start' => $detail->start ? Carbon::parse($detail->start)->format('Y-m-d H:i:s') : 'N/A',
                    'Finish' => $detail->finish ? Carbon::parse($detail->finish)->format('Y-m-d H:i:s') : 'N/A',
                    'Duration' => $this->calculateDetailsDuration($detail),
                    'Memo' => $detail->note,
                ];
            }
        }

        return collect($data);
    }

    /**
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            ['Project', 'Duration'],
        ];
    }

    /**
     *
     * @param $detail
     * @return string
     */
    private function calculateDetailsDuration($detail): string
    {
        if ($detail->start && $detail->finish) {
            $start = Carbon::parse($detail->start);
            $finish = Carbon::parse($detail->finish);
            return $this->formatDuration($finish->diff($start));
        }
        return 'N/A';
    }

    /**
     *
     * @param $project
     * @return string
     */
    private function calculateProjectDuration($project): string
    {
        $totalDurationInSeconds = 0;

        foreach ($project->projectDetails as $detail) {
            if ($detail->start && $detail->finish) {
                $start = Carbon::parse($detail->start);
                $finish = Carbon::parse($detail->finish);

                $totalDurationInSeconds += $finish->diffInSeconds($start);
            }
        }

        return $this->formatDuration(
            Carbon::createFromTimestamp(0)->diff(Carbon::createFromTimestamp($totalDurationInSeconds))
        );
    }

    /**
     *
     * @param \DateInterval $interval
     * @return string
     */
    private function formatDuration(\DateInterval $interval): string
    {
        $hours = ($interval->y * 8760) + ($interval->m * 730) + ($interval->d * 24) + $interval->h;
        $minutes = $interval->i;
        $seconds = $interval->s;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }
}
