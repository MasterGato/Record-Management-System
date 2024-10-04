<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource; // Reference to the UserResource
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords // Correctly extends ListRecords
{
    protected static string $resource = UserResource::class; // Correctly reference UserResource

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
