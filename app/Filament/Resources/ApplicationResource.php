<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApplicationResource\Pages;
use App\Models\Application;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ApplicationResource extends Resource
{
    protected static ?string $model = Application::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('Typeofapplication')
                    ->label('Type of Application')
                    ->options([
                        'newapplicant' => 'New Applicant',
                        'returnee' => 'Returnee',
                    ])
                    ->required(), // Mark as required

                // Ensure relationships and fields are referenced correctly
                Forms\Components\Select::make('applicant_id')
                    ->relationship('applicant', 'Firstname') // Adjusted casing
                    ->required(),

                Forms\Components\Select::make('job_offer_id') // Consistent naming
                    ->relationship('jobOffer', 'Job') // Adjusted casing
                    ->required(),

                Forms\Components\Select::make('branch_id')
                    ->relationship('branch', 'branchname')
                    ->required(),

                Forms\Components\TextInput::make('status')->default('pending')->required(),
                
                Forms\Components\DatePicker::make('Dateofapplication')
                    ->default(now())
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('Typeofapplication'),
                Tables\Columns\TextColumn::make('applicant.Firstname'), // Ensure this matches the relationship name
                Tables\Columns\TextColumn::make('jobOffer.Job'), // Ensure this matches the relationship name
                Tables\Columns\TextColumn::make('branch.branchname'), // Ensure this matches the relationship name
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('Dateofapplication'),
                // Remove this line if `application_date` is not a valid column
                // Tables\Columns\TextColumn::make('application_date'),
            ])
            ->filters([]);
    }

    public static function getRelations(): array
    {
        return [
            // Define any relations if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApplications::route('/'),
            'create' => Pages\CreateApplication::route('/create'),
            'edit' => Pages\EditApplication::route('/{record}/edit'),
        ];
    }
}