<?php

namespace App\Filament\Resources\RejectedApplicantsResource\Pages;

use App\Filament\Resources\RejectedApplicantsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRejectedApplicants extends ListRecords
{
    protected static string $resource = RejectedApplicantsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
