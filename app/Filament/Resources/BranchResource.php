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
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\EditAction;
use Filament\Facades\Filament;
use Illuminate\Validation\Rule;

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
                    ->required()
                    // Ensure the branch name is unique in the 'branches' table
                    ->rules([
                        'required',
                        Rule::unique('branches', 'branchname')->ignore(request()->route('record')), 
                    ])
                    ->validationAttribute('branch name'), // Optional: customize attribute name in validation error message
                
                Forms\Components\Select::make('region')
                    ->label('Region')
                    ->options(self::getRegions())
                    ->reactive()
                    ->afterStateUpdated(fn(callable $set) => $set('province', null))
                    ->afterStateUpdated(fn(callable $set) => $set('city', null)),
    
                Forms\Components\Select::make('province')
                    ->label('Province')
                    ->options(function (callable $get) {
                        return self::getProvinces($get('region'));
                    })
                    ->reactive()
                    ->afterStateUpdated(fn(callable $set) => $set('city', null))
                    ->required(),
    
                Forms\Components\Select::make('city')
                    ->label('City')
                    ->options(function (callable $get) {
                        return self::getCities($get('province'));
                    })
                    ->reactive()
                    ->required(),
    
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ])
                    ->required()
                    ->default('active'),
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
            ->actions([
                ForceDeleteAction::make(),
                RestoreAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRegions(): array
    {
        $json = Storage::get('locations.json');
        $locations = json_decode($json, true);

        return collect($locations)->mapWithKeys(function ($regionData, $regionName) {
            return [$regionName => $regionData['region_name']];
        })->toArray();
    }

    public static function getProvinces(?string $region): array
    {
        if (is_null($region)) {
            return [];
        }

        $json = Storage::get('locations.json');
        $locations = json_decode($json, true);

        return collect($locations[$region]['province_list'] ?? [])
            ->mapWithKeys(fn($provinceData, $provinceName) => [$provinceName => $provinceName])
            ->toArray();
    }

    public static function getCities(?string $province): array
    {
        if (is_null($province)) {
            return [];
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
