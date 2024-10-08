<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActiveUserResource\Pages;
use App\Filament\Resources\ActiveUserResource\RelationManagers;
use App\Models\ActiveUser;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Tables\Filters\SelectFilter;

class ActiveUserResource extends Resource
{
    protected static ?string $model = User::class;

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
                Tables\Columns\TextColumn::make('name')
                ->label('Username')
                ->searchable(),
            Tables\Columns\TextColumn::make('firstname')
                ->searchable(),
            Tables\Columns\TextColumn::make('lastname')
                ->searchable(),
            Tables\Columns\TextColumn::make('middlename')
                ->searchable(),
            Tables\Columns\TextColumn::make('gender')
                ->searchable(),
            Tables\Columns\TextColumn::make('contact')
                ->searchable(),
            Tables\Columns\TextColumn::make('email')
                ->searchable(),
            Tables\Columns\TextColumn::make('branch.branchname')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('role')
                ->searchable(),
            Tables\Columns\TextColumn::make('status')
                ->searchable(),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),
            Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
               
            ])
            ->filters([
                SelectFilter::make('user_id') // Add the branch filter
                    ->label('User')
                    ->options(User::pluck('status', 'id')) // List of branches
                    ->searchable(),
            ])
            ->actions([
               
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
            'index' => Pages\ListActiveUsers::route('/'),
            'create' => Pages\CreateActiveUser::route('/create'),
            'edit' => Pages\EditActiveUser::route('/{record}/edit'),
        ];
    }
}
