<?php

namespace App\Filament\Resources\ReturneeApplicantsResource\Pages;

use App\Filament\Resources\ReturneeApplicantsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReturneeApplicants extends ListRecords
{
    protected static string $resource = ReturneeApplicantsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
