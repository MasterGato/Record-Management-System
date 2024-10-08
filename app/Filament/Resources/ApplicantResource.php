<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApplicantResource\Pages;
use App\Models\Applicant;
use App\Models\Barangay;
use App\Models\Branch; // Import the Branch model for the relationship
use App\Models\Region; // Import the Region model
use App\Models\Province; // Import the Province model
use App\Models\Municipality; // Import the Municipality model
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Forms\Components\DatePicker;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section as InfolistSection; // Correct Infolist Section import
use Filament\Forms\Components\Section;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Storage;

class ApplicantResource extends Resource
{
    protected static ?string $model = Applicant::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Applicant Information')
                    ->schema([
                        TextInput::make('name')
                            ->label('Username')
                            ->required(),
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
                        
                        // Implementing dynamic location fields
                        Select::make('region_id')
                            ->label('Region')
                            ->options(function () {
                                return Region::all()->pluck('region_name', 'id');
                            })
                            ->reactive() // Make it reactive
                            ->afterStateUpdated(function (callable $set) {
                                $set('province_id', null); // Reset province when region changes
                                $set('municipality_id', null); // Reset city when region changes
                                $set('barangay_id', null); // Reset barangay when region changes
                            })
                            ->required(),

                        Select::make('province_id')
                            ->label('Province')
                            ->options(function (callable $get) {
                                $regionId = $get('region_id');
                                return Province::where('region_id', $regionId)->pluck('province_name', 'id');
                            })
                            ->reactive() // Make it reactive
                            ->afterStateUpdated(function (callable $set) {
                                $set('municipality_id', null); // Reset city when province changes
                                $set('barangay_id', null); // Reset barangay when province changes
                            })
                            ->required(),

                        Select::make('municipality_id')
                            ->label('Municipality')
                            ->options(function (callable $get) {
                                $provinceId = $get('province_id');
                                return Municipality::where('province_id', $provinceId)->pluck('municipality_name', 'id');
                            })
                            ->reactive() // Make it reactive
                            ->afterStateUpdated(function (callable $set) {
                                $set('barangay_id', null); // Reset barangay when municipality changes
                            })
                            ->required(),

                        Select::make('barangay_id')
                            ->label('Barangay')
                            ->options(function (callable $get) {
                                $municipalityId = $get('municipality_id');
                                return Barangay::where('municipality_id', $municipalityId)->pluck('barangay_name', 'id');
                            })
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
                            ->label('Educational Attainments & Work Experiences')
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
                SelectFilter::make('branch_id') // Add the branch filter
                    ->label('Branch')
                    ->options(Branch::pluck('branchname', 'id')) // List of branches
                    ->searchable(),
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
                InfolistSection::make('Applicant Information')
                    ->schema([
                        TextEntry::make('branch.branchname') // Displaying the branch name
                            ->label('Branch'),
                        TextEntry::make('Firstname')
                            ->label('First Name'),
                        TextEntry::make('Lastname')
                            ->label('Last Name'),
                        TextEntry::make('Email')
                            ->label('Email'),
                    ])
                    ->columns(2), // Ensure 'columns' is lowercase
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
