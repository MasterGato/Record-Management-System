<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BranchResource\Pages;
use App\Filament\Resources\BranchResource\RelationManagers;
use App\Models\Branch;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;


class BranchResource extends Resource
{
    protected static ?string $model = Branch::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('Branchname')
                ->label('Branch Name')
                ->required(),
               
            Select::make('Region')
                ->label('Region')
                ->options([
                    'region 12' => 'Region 12',
                    'region 11' => 'Region 11',
                ])
                ->reactive() // Make the field reactive to changes
                ->afterStateUpdated(fn(callable $set) => $set('selectedProvince', null)) // Reset province when region changes
                ->afterStateUpdated(fn(callable $set) => $set('selectedCity', null)), // Reset city when region changes,

            Select::make('Province')
                ->label('Province')
                ->options(function (callable $get) {
                    $region = $get('Region');
                    if ($region === 'region 12') {
                        return [
                            'south Cotabato' => 'South Cotabato',
                            'sultan Kudarat' => 'Sultan Kudarat',
                        ];
                    } elseif ($region === 'region 11') {
                        return [
                            'davao del sur' => 'Davao Del Sur',
                            'davao del norte' => 'Davao Del Norte',
                        ];
                    }
                    return [];
                })
                ->reactive() // Make the field reactive to changes
                ->afterStateUpdated(fn(callable $set) => $set('selectedCity', null)) // Reset city when province changes
                ->required(),

            Select::make('City')
                ->label('City')
                ->options(function (callable $get) {
                    $province = $get('Province');
                    if ($province === 'south Cotabato') {
                        return [
                            'koronadal' => 'Koronadal',
                            'surallah' => 'Surallah',
                            'isulan' => 'Isulan',
                            'tacurong' => 'Tacurong',
                        ];
                    } elseif ($province === 'davao del sur') {
                        return [
                            'matanao' => 'Martanao',
                            'digos' => 'Digos',
                        ];
                    }
                    return [];
                })
                ->reactive() // Make the field reactive to changes
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('branchname')
                    ->searchable(),
                Tables\Columns\TextColumn::make('region')
                    ->searchable(),
                Tables\Columns\TextColumn::make('province')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
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
