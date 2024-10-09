<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ListofApplicantsResource\Pages;
use App\Filament\Resources\ListofApplicantsResource\RelationManagers;
use App\Models\Applicant;
use App\Models\ListofApplicants;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ListofApplicantsResource extends Resource
{
    protected static ?string $model = Applicant::class;


    protected static ?string $modelLabel = 'List of Applicants';
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
            TextColumn::make('Firstname')
                ->label('First Name')
                ->sortable()
                ->searchable(),
                TextColumn::make('Middleinitial')
                ->label('Middle Initial')
                ->sortable()
                ->searchable(),

            TextColumn::make('Lastname')
                ->label('Last Name')
                ->sortable()
                ->searchable(),

                TextColumn::make('Email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('branch.branchname')
                    ->label('Branch')
                    ->searchable()
                    ->sortable(),
                    
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
            'index' => Pages\ListListofApplicants::route('/'),
            'create' => Pages\CreateListofApplicants::route('/create'),
            'edit' => Pages\EditListofApplicants::route('/{record}/edit'),
        ];
    }
}
