<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HiredApplicantsResource\Pages;
use App\Filament\Resources\HiredApplicantsResource\RelationManagers;
use App\Models\Application;
use App\Models\Applicant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HiredApplicantsResource extends Resource
{
    protected static ?string $model = Application::class;

    protected static ?string $modelLabel = 'Hired Applicants';
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
            Tables\Columns\TextColumn::make('id')
                ->label('Application ID')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('Typeofapplication')
                ->label('Type of Application')
                    ->sortable()
                    ->searchable(),

            // Adding a computed column for Full Name
            Tables\Columns\TextColumn::make('applicant.Firstname')
                ->label('First Name')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('applicant.Middleinitial')
                ->label('Middle Initial')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('applicant.Lastname')
                ->label('Last Name')
                ->sortable()
                ->searchable(),


            Tables\Columns\TextColumn::make('jobOffer.Job'),

            Tables\Columns\TextColumn::make('branch.branchname'),

            Tables\Columns\TextColumn::make('status')
                ->label('Status'),

            Tables\Columns\TextColumn::make('Dateofapplication'),

            Tables\Columns\TextColumn::make('Controlnumber'),
        ])
            ->filters([
                //
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
    public static function getEloquentQuery(): Builder
    {
        return Application::with('applicant')->where('status', 'hired');
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
            'index' => Pages\ListHiredApplicants::route('/'),
            'create' => Pages\CreateHiredApplicants::route('/create'),
            'edit' => Pages\EditHiredApplicants::route('/{record}/edit'),
        ];
    }
}
