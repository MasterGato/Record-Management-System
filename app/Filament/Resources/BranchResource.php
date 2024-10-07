<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BranchResource\Pages;
use App\Models\Branch;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Filament\Tables\Filters\SelectFilter;

class BranchResource extends Resource
{
    protected static ?string $model = Branch::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('branchname')
                    ->label('Branch Name')
                    ->default('MMML-')
                    ->required(),

                Forms\Components\Select::make('region')
                    ->label('Region')
                    ->options(self::getRegions())
                    ->reactive() // Make the field reactive to changes
                    ->afterStateUpdated(fn(callable $set) => $set('province', null)) // Reset province when region changes
                    ->afterStateUpdated(fn(callable $set) => $set('city', null)), // Reset city when region changes

                Forms\Components\Select::make('province')
                    ->label('Province')
                    ->options(function (callable $get) {
                        return self::getProvinces($get('region'));
                    })
                    ->reactive() // Make the field reactive to changes
                    ->afterStateUpdated(fn(callable $set) => $set('city', null)) // Reset city when province changes
                    ->required(),

                Forms\Components\Select::make('city')
                    ->label('City')
                    ->options(function (callable $get) {
                        return self::getCities($get('province'));
                    })
                    ->reactive() // Make the field reactive to changes
                    ->required(),

                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ])
                    ->required()
                    ->default('active'), // Default status should match option keys
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('branchname')
                    ->label('Branch Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('region')
                    ->label('Region')
                    ->searchable(),
                Tables\Columns\TextColumn::make('province')
                    ->label('Province')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->label('City')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->searchable(),
                    
            ])
            ->filter([
                //SelectFilter::make('branch')
                  //->option(Branch::pluck('branch','branchname'))
            ])
            ->actions([
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRegions(): array
    {
        // Load the JSON data
        $json = Storage::get('locations.json');
        $locations = json_decode($json, true);

        // Extract regions
        return collect($locations)->mapWithKeys(function ($regionData, $regionName) {
            return [$regionName => $regionData['region_name']];
        })->toArray();
    }

    public static function getProvinces(?string $region): array
    {
        // Check if region is null
        if (is_null($region)) {
            return []; // Return empty array if no region is selected
        }

        $json = Storage::get('locations.json');
        $locations = json_decode($json, true);

        return collect($locations[$region]['province_list'] ?? [])
            ->mapWithKeys(fn($provinceData, $provinceName) => [$provinceName => $provinceName])
            ->toArray();
    }

    public static function getCities(?string $province): array
    {
        // Check if province is null
        if (is_null($province)) {
            return []; // Return empty array if no province is selected
        }

        $json = Storage::get('locations.json');
        $locations = json_decode($json, true);

        foreach ($locations as $regionData) {
            foreach ($regionData['province_list'] as $provinceName => $provinceData) {
                if ($provinceName === $province) {
                    return collect($provinceData['municipality_list'] ?? [])
                        ->mapWithKeys(fn($municipality, $municipalityName) => [$municipalityName => $municipalityName])
                        ->toArray();
                }
            }
        }

        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBranches::route('/'),
            'create' => Pages\CreateBranch::route('/create'),
            'edit' => Pages\EditBranch::route('/{record}/edit'),
        ];
    }
}
