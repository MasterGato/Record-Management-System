<?php

namespace App\Filament\Resources\HiredApplicantsResource\Pages;

use App\Filament\Resources\HiredApplicantsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHiredApplicants extends EditRecord
{
    protected static string $resource = HiredApplicantsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
