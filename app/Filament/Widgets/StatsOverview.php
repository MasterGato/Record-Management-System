<?php

namespace App\Filament\Widgets;

use App\Models\Applicant;
use App\Models\Application;
use App\Models\Branch;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Branches', Branch::count())
                ->description('Number of Branches')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart($this->generateChartData(Branch::count())),

            Stat::make('Applicants', Applicant::count())
                ->description('Number of Applicants')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart($this->generateChartData(Applicant::count())),

            Stat::make('Applications', Application::count())
                ->description('Number of Applications')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart($this->generateChartData(Application::count())),
            Stat::make('Hired Applicants', Application::where('status', 'hired')->count())
                ->description('Number of Hired Applicants')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart($this->generateChartData(Application::where('status', 'hired')->count())),
        ];
    }

    // Helper function to generate dynamic chart data
    private function generateChartData($count): array
    {
        // Generate an array of values based on the current count
        $chartData = [];
        for ($i = 0; $i < 7; $i++) {
            $chartData[] = max(0, $count + rand(-5, 5)); // Slight variation to simulate real data
        }
        return $chartData;
    }
}
