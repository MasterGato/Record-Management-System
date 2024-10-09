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
    protected static ?int $navigationSort = 9;
    protected static string $view = 'filament.pages.report-page';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';

    protected function getActions(): array
    {
        return [
            
         
        ];
    }

    public function generateActiveUserReport()
    {
       
    }
}