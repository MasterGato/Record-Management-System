<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Branch;
use Illuminate\Support\Facades\DB;

class BranchChart extends ChartWidget
{
    protected static ?string $heading = 'Branch Applicants and Applications';
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 2;

    // Store the selected year
    public ?int $selectedYear = null;

    protected function getData(): array
    {
        // Query to get branches with the number of applicants and applications, filtered by the selected year
        $query = Branch::select('branches.branchname')
            ->leftJoin('applicants', 'branches.id', '=', 'applicants.branch_id')
            ->leftJoin('applications', 'branches.id', '=', 'applications.branch_id')
            ->selectRaw('count(DISTINCT applicants.id) as total_applicants')
            ->selectRaw('count(DISTINCT applications.id) as total_applications')
            ->groupBy('branches.branchname');

        // Apply year filtering if a year is selected
        if ($this->selectedYear) {
            $query->whereYear('applications.Dateofapplication', $this->selectedYear);
        }

        $branchesData = $query->get();

        // Format data for the chart
        $branchNames = $branchesData->pluck('branchname')->toArray();
        $applicantCounts = $branchesData->pluck('total_applicants')->toArray();
        $applicationCounts = $branchesData->pluck('total_applications')->toArray();

        return [
            'labels' => $branchNames,
            'datasets' => [
                [
                    'label' => 'Applicants',
                    'backgroundColor' => 'rgba(54, 162, 235, 0.7)',
                    'data' => $applicantCounts,
                ],
                [
                    'label' => 'Applications',
                    'backgroundColor' => 'rgba(255, 99, 132, 0.7)',
                    'data' => $applicationCounts,
                ],
            ],
            'options' => [
                'scales' => [
                    'y' => [
                        'ticks' => [
                            'beginAtZero' => true,
                            'precision' => 0, // Ensure whole numbers on y-axis
                        ],
                    ],
                ],
            ],
        ];
    }

    // Function to set the selected year and refresh the chart
    public function setSelectedYear($year): void
    {
        $this->selectedYear = $year;
        $this->refresh(); // Refresh the chart after updating the year
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
