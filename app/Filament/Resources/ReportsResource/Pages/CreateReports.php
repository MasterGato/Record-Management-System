<?php

namespace App\Filament\Resources\ReportsResource\Pages;

use App\Filament\Resources\ReportsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Redirect;

class CreateReports extends CreateRecord
{
    protected static string $resource = ReportsResource::class;

    protected function submit(): void
    {
        // Handle redirection instead of saving the record
        $reportType = $this->form->getState()['reportType']; // Access the submitted report type
        $startDate = $this->form->getState()['startDate'];   // Access the submitted start date
        $endDate = $this->form->getState()['endDate'];       // Access the submitted end date

        // Redirect to the desired route with the submitted data
        Redirect::route('your.route.name', [
            'reportType' => $reportType,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }
}
