<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApplicantResource\Pages;
use App\Models\Applicant;
use App\Models\Branch; // Import the Branch model for the relationship
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;

class ApplicantResource extends Resource
{
    protected static ?string $model = Applicant::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Applicant Information')
                    ->schema([
                        // Branch selection (relationship with the Branch model)
                        Select::make('branch_id')
                            ->label('Branch')
                            ->relationship('branch', 'Branchname') // Assuming 'Branchname' is the display field
                            ->required(),

                        // Applicant information fields
                        TextInput::make('Firstname')
                            ->label('First Name')
                            ->required(),
                        TextInput::make('Lastname')
                            ->label('Last Name')
                            ->required(),
                        TextInput::make('Middleinitial')
                            ->label('Middle Initial')
                            ->nullable(),
                        Select::make('Gender')
                            ->label('Gender')
                            ->options([
                                'Male' => 'Male',
                                'Female' => 'Female',
                                'Other' => 'Other',
                            ])
                            ->required(),
                        TextInput::make('Contact')
                            ->label('Contact')
                            ->required(),
                        TextInput::make('Email')
                            ->label('Email')
                            ->email()
                            ->required(),
                        DatePicker::make('Dateofbirth')
                            ->label('Date of Birth')
                            ->required(),
                        TextInput::make('Citizenship')
                            ->label('Citizenship')
                            ->required(),
                        TextInput::make('Region')
                            ->label('Region')
                            ->required(),
                        TextInput::make('Province')
                            ->label('Province')
                            ->required(),
                        TextInput::make('City')
                            ->label('City')
                            ->required(),
                        TextInput::make('Brgy')
                            ->label('Barangay')
                            ->required(),
                        TextInput::make('Zipcode')
                            ->label('Zipcode')
                            ->required(),
                        TextInput::make('Password')
                            ->label('Password')
                            ->password()
                            ->required(),
                    ])->columns(2),

                Section::make('Educational Attainment')
                    ->schema([
                        // Educational Attainment (Repeatable field)
                        Repeater::make('educationalAttainments')
                            ->label('Educational Attainments')
                            ->relationship()
                            ->schema([
                                TextInput::make('Level')
                                    ->label('Education Level')
                                    ->required(),
                                TextInput::make('Institution')
                                    ->label('Institution Name')
                                    ->required(),
                                TextInput::make('Inclusivedate')
                                    ->label('Inclusive Dates')
                                    ->required(),
                            ])
                            ->createItemButtonLabel('Add Educational Attainment'),

                        // Work Experience (Repeatable field)
                        Repeater::make('workExperiences')
                            ->label('Work Experiences')
                            ->relationship()
                            ->schema([
                                TextInput::make('Company')
                                    ->label('Company Name')
                                    ->required(),
                                TextInput::make('Work')
                                    ->label('Work Position')
                                    ->required(),
                                TextInput::make('Years')
                                    ->label('Years of Experience')
                                    ->required(),
                            ])
                            ->createItemButtonLabel('Add Work Experience'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('Firstname')->label('First Name'),
                TextColumn::make('Lastname')->label('Last Name'),
                TextColumn::make('Email')->label('Email'),
                TextColumn::make('branch.branchname')->label('Branch'),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Applicant Information')
                    ->schema([
                        TextEntry::make('branch.branchname')->label('Branch'), // Corrected line
                        TextEntry::make('Firstname')->label('First Name'),
                        TextEntry::make('Lastname')->label('Last Name'),
                        TextEntry::make('Email')->label('Email'),
                    ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Add relations if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApplicants::route('/'),
            'create' => Pages\CreateApplicant::route('/create'),
            'edit' => Pages\EditApplicant::route('/{record}/edit'),
        ];
    }
}
