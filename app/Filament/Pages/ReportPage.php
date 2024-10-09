<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Pages\Page;
use Carbon\Carbon;
use Filament\Forms\Components\Button;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use Filament\Actions\Action;


class ReportPage extends Page
{
    protected static ?string $navigationLabel = 'Report Page';
    protected static string $view = 'filament.pages.report-page';

    protected function getActions(): array
    {
        return [
            Action::make('generateActiveUserReport')
                ->label('Download Active Users Report') // Button label
                ->action('generateActiveUserReport') // Method to call when the button is clicked
                ->color('primary'), // Optional: set the button color
        ];
    }

    public function generateActiveUserReport()
    {
        // Fetch active users
        $users = User::with('branch')->where('status', 'Active')->get();

        // Load the PDF view and pass data to it
        $pdf = PDF::loadView('active_users_report', ['employees' => $users]);

        // Stream the generated PDF
        return $pdf->stream('active_users_report.pdf');
    }
}