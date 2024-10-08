<?php

namespace App\Filament\Resources\ActiveUserResource\Pages;

use App\Filament\Resources\ActiveUserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListActiveUsers extends ListRecords
{
    protected static string $resource = ActiveUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
        
        ];
    }
}
