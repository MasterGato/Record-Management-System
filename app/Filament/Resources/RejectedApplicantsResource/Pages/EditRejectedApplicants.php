<?php

namespace App\Filament\Resources\RejectedApplicantsResource\Pages;

use App\Filament\Resources\RejectedApplicantsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRejectedApplicants extends EditRecord
{
    protected static string $resource = RejectedApplicantsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
