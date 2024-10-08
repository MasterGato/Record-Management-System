<?php

namespace App\Filament\Resources\BranchPerformanceResource\Pages;

use App\Filament\Resources\BranchPerformanceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBranchPerformance extends EditRecord
{
    protected static string $resource = BranchPerformanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
