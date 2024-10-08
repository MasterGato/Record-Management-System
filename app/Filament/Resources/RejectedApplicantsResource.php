<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RejectedApplicantsResource\Pages;
use App\Filament\Resources\RejectedApplicantsResource\RelationManagers;
use App\Models\Application;
use App\Models\RejectedApplicants;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RejectedApplicantsResource extends Resource
{
    protected static ?string $model = Application::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Reports';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRejectedApplicants::route('/'),
            'create' => Pages\CreateRejectedApplicants::route('/create'),
            'edit' => Pages\EditRejectedApplicants::route('/{record}/edit'),
        ];
    }
}
