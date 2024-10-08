<?php

namespace App\Filament\Resources\ListofApplicantsResource\Pages;

use App\Filament\Resources\ListofApplicantsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditListofApplicants extends EditRecord
{
    protected static string $resource = ListofApplicantsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
