<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobOfferResource\Pages;
use App\Models\JobOffer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use App\Models\Country;

class JobOfferResource extends Resource
{
    protected static ?string $model = JobOffer::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('Job') // Ensure this matches the DB column name
                    ->label('Job Title')
                    ->required()
                    ->maxLength(255),

                Select::make('country_id')
                    ->label('Country')
                    ->searchable()
                    ->options(Country::all()->pluck('name', 'id'))
                    ->required(),
                
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'available' => 'Available',
                        'unavailable' => 'Unavailable'
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('Job') // Ensure this matches the DB column name
                    ->label('Job Title')
                    ->searchable(),

                Tables\Columns\TextColumn::make('country.name')
                    ->label('Country')
                    ->searchable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->searchable(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJobOffers::route('/'),
            'create' => Pages\CreateJobOffer::route('/create'),
            'edit' => Pages\EditJobOffer::route('/{record}/edit'),
        ];
    }
}

