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
use Illuminate\Validation\Rule; // Import Rule for custom validation

class JobOfferResource extends Resource
{
    protected static ?string $model = JobOffer::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // The job field with unique validation
                Forms\Components\TextInput::make('Job') // Changed to lowercase to match DB column if needed
                    ->label('Job Title') // Optionally give a more descriptive label
                    ->required()
                    ->maxLength(255)
                    ->reactive()
                    ->rules([
                        'required', 
                        'max:255',
                    ]),
                
                // Country selection field
                Select::make('country_id')
                    ->label('Country')
                    ->searchable()
                    ->options(Country::all()->pluck('name', 'id'))
                    ->required(),
                
                // Status field
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'available' => 'Available',
                        'unavailable' => 'Unavailable'
                    ])
                    ->native(false)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Job column
                Tables\Columns\TextColumn::make('Job') // Changed to lowercase 'job' to match form
                    ->label('Job Title')
                    ->searchable(),
                
                // Country column
                Tables\Columns\TextColumn::make('country.name')
                    ->label('Country')
                    ->searchable(),
                
                // Status column
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->searchable(),
            ])
            ->filters([
                // You can add filters here if needed
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
            // Add any relations if needed
        ];
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
