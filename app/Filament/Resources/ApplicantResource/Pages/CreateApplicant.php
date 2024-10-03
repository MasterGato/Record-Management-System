<?php

namespace App\Filament\Resources\ApplicantResource\Pages;

use App\Filament\Resources\ApplicantResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateApplicant extends CreateRecord
{
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected static string $resource = ApplicantResource::class;
}
