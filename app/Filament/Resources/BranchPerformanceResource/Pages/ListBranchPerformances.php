<?php

namespace App\Filament\Resources\BranchPerformanceResource\Pages;

use App\Filament\Resources\BranchPerformanceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBranchPerformances extends ListRecords
{
    protected static string $resource = BranchPerformanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
