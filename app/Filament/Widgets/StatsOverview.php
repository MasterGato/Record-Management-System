<?Php 

namespace App\Filament\Widgets;

use App\Models\Applicant;
use App\Models\Application;
use App\Models\Branch;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $user = Auth::user();
        $isAdmin = $user->role === 'admin'; // Check if the user is an admin
        $branchId = $user->branch_id; // Get the user's branch ID

        // Overall data if admin, or filtered data for branch if not admin
        $applicantsCount = $isAdmin ? Applicant::count() : Applicant::where('branch_id', $branchId)->count();
        $applicationsCount = $isAdmin ? Application::count() : Application::where('branch_id', $branchId)->count();
        $hiredApplicantsCount = $isAdmin ? Application::where('status', 'hired')->count() : Application::where('branch_id', $branchId)->where('status', 'hired')->count();

        return [
            // Adding branch display
            Stat::make('Current Branch', $user->branch->branchname ?? 'N/A') // Assuming User model has a relationship with Branch
                ->description('Branch of the logged-in user')
                ->descriptionIcon('heroicon-m-flag')
                ->color('info'),

            Stat::make('Branches', Branch::count())
                ->description('Number of Branches')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart($this->generateChartData(Branch::count())),

            Stat::make('Applicants', $applicantsCount)
                ->description('Number of Applicants')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart($this->generateChartData($applicantsCount)),

            Stat::make('Applications', $applicationsCount)
                ->description('Number of Applications')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart($this->generateChartData($applicationsCount)),

            Stat::make('Hired Applicants', $hiredApplicantsCount)
                ->description('Number of Hired Applicants')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart($this->generateChartData($hiredApplicantsCount)),
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
