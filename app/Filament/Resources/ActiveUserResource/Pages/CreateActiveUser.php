<?php

namespace App\Filament\Resources\ActiveUserResource\Pages;

use App\Filament\Resources\ActiveUserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateActiveUser extends CreateRecord
{
    protected static string $resource = ActiveUserResource::class;
}
