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
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Forms\Components\DatePicker;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section as InfolistSection; // Correct Infolist Section import
use Filament\Forms\Components\Section;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ApplicantResource extends Resource
{
    protected static ?string $model = Applicant::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';
    protected static ?int $navigationSort = 4;

    // Method to fetch provinces using the API
    public function fetchRegions()
    {
        return Http::get('https://psgc.gitlab.io/api/regions/')->json();
    }

    public function fetchProvinces($regionCode)
    {
        return Http::get("https://psgc.gitlab.io/api/regions/{$regionCode}/provinces/")->json();
    }

    public function fetchCities($provinceCode)
    {
        return Http::get("https://psgc.gitlab.io/api/provinces/{$provinceCode}/cities-municipalities/")->json();
    }

    public function fetchBarangays($cityCode)
    {
        return Http::get("https://psgc.gitlab.io/api/cities-municipalities/{$cityCode}/barangays/")->json();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Applicant Information')
                    ->schema([

                        Select::make('branch_id')
                            ->label('Branch')
                            ->relationship('branch', 'Branchname')
                            ->required(),

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

                        // Dynamic API-based location fields
                        Select::make('Region')
                            ->label('Region')
                            ->options(function () {
                                $regions = (new static)->fetchRegions();
                                return collect($regions)->pluck('name', 'code');
                            })
                            ->reactive()
                            ->afterStateUpdated(function (callable $set) {
                                $set('province', null);
                                $set('city', null);
                                $set('barangay', null);
                            })
                            ->required(),

                        Select::make('Province')
                            ->label('Province')
                            ->options(function (callable $get) {
                                $regionCode = $get('Region');
                                if ($regionCode) {
                                    $provinces = (new static)->fetchProvinces($regionCode);
                                    return collect($provinces)->pluck('name', 'code');
                                }
                                return [];
                            })
                            ->reactive()
                            ->afterStateUpdated(function (callable $set) {
                                $set('city', null);
                                $set('barangay', null);
                            })
                            ->required(),

                        Select::make('City')
                            ->label('Municipality')
                            ->options(function (callable $get) {
                                $provinceCode = $get('Province');
                                if ($provinceCode) {
                                    $cities = (new static)->fetchCities($provinceCode);
                                    return collect($cities)->pluck('name', 'code');
                                }
                                return [];
                            })
                            ->reactive()
                            ->afterStateUpdated(function (callable $set) {
                                $set('barangay', null);
                            })
                            ->required(),

                        Select::make('Brgy')
                            ->label('Barangay')
                            ->options(function (callable $get) {
                                $cityCode = $get('City');
                                if ($cityCode) {
                                    $barangays = (new static)->fetchBarangays($cityCode);
                                    return collect($barangays)->pluck('name', 'code');
                                }
                                return [];
                            })
                            ->required(),

                        TextInput::make('Zipcode')
                            ->label('Zipcode')
                            ->required(),

                    ])->columns(2),

                Section::make('Educational Attainment')
                    ->schema([
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
                        TextEntry::make('branch.branchname')
                            ->label('Branch'),
                        TextEntry::make('Firstname')
                            ->label('First Name'),
                        TextEntry::make('Lastname')
                            ->label('Last Name'),
                        TextEntry::make('Email')
                            ->label('Email'),
                    ])
                    ->columns(2),
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
