<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;

class BranchChart extends ChartWidget
{
    protected static ?string $heading = 'Branch Applicants, Applications, and Hired Applicants';
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 2;

    // Store the selected year and branch
    public ?int $selectedYear = null;
    public ?int $selectedBranchId = null;

    protected function getData(): array
    {
        // Get the currently authenticated user
        $user = Auth::user();
        $isAdmin = $user->role === 'admin';
        
        // Base query to get branches with the number of applicants, applications, and hired applicants
        $query = Branch::select('branches.id', 'branches.branchname')
            ->leftJoin('applicants', 'branches.id', '=', 'applicants.branch_id')
            ->leftJoin('applications', 'branches.id', '=', 'applications.branch_id')
            ->selectRaw('count(DISTINCT applicants.id) as total_applicants')
            ->selectRaw('count(DISTINCT applications.id) as total_applications')
            ->selectRaw("count(DISTINCT CASE WHEN applications.status = 'hired' THEN applications.id END) as total_hired_applicants")
            ->groupBy('branches.id', 'branches.branchname');

        // Apply year filtering if a year is selected
        if ($this->selectedYear) {
            $query->whereYear('applications.Dateofapplication', $this->selectedYear);
        }

        // Apply branch filtering if not admin
        if (!$isAdmin) {
            $query->where('branches.id', $user->branch_id);
        }

        $branchesData = $query->get();

        // Format data for the chart
        $branchNames = $branchesData->pluck('branchname')->toArray();
        $applicantCounts = $branchesData->pluck('total_applicants')->toArray();
        $applicationCounts = $branchesData->pluck('total_applications')->toArray();
        $hiredApplicantCounts = $branchesData->pluck('total_hired_applicants')->toArray();

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
                [
                    'label' => 'Hired Applicants',
                    'backgroundColor' => 'rgba(75, 192, 192, 0.7)',
                    'data' => $hiredApplicantCounts,
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

    // Function to set the selected branch and refresh the chart
    public function setSelectedBranch($branchId): void
    {
        $this->selectedBranchId = $branchId;
        $this->refresh(); // Refresh the chart after updating the branch
    }

    protected function getType(): string
    {
        return 'bar';
    }

    // Get the available branches for filtering
    protected function getBranches(): array
    {
        return Branch::all()->pluck('branchname', 'id')->toArray();
    }

    // Render the widget with branch filter
    protected function getViewData(): array
    {
        return [
            'branches' => $this->getBranches(), // Pass branches data to the view
        ];
    }
}
