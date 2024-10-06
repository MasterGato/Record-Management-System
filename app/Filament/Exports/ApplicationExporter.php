<?php

namespace App\Filament\Exports;

use App\Models\Application;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class ApplicationExporter extends Exporter
{
    protected static ?string $model = Application::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id'),
            ExportColumn::make('Typeofapplication'),
            ExportColumn::make('Dateofapplication'),
            ExportColumn::make('Controlnumber'),
            ExportColumn::make('status'),
        ];
    }

    // After export completion, this method sends the notification
    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your application export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' were exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        // Send a notification to the user
        $user = Auth::user(); // Get the currently logged-in user
        Notification::make()
            ->title('Export Completed')
            ->success()
            ->body($body)
            ->sendTo($user); // Send the notification to the current user

        return $body;
    }
}

