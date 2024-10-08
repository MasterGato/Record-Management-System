<?php

namespace App\Filament\Resources\ListofApplicantsResource\Pages;

use App\Filament\Resources\ListofApplicantsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListListofApplicants extends ListRecords
{
    protected static string $resource = ListofApplicantsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
