<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApplicationResource\Pages;
use App\Models\Application;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;

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
                    ->required(),

                Forms\Components\Select::make('applicant_id')
                    ->relationship('applicant', 'Firstname')
                    ->required(),

                Forms\Components\Select::make('job_offer_id')
                    ->relationship('jobOffer', 'Job')
                    ->required(),

                Forms\Components\Select::make('branch_id')
                    ->relationship('branch', 'branchname')
                    ->required(),

                // Removed status field
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
                Tables\Columns\TextColumn::make('applicant.Firstname'),
                Tables\Columns\TextColumn::make('jobOffer.Job'),
                Tables\Columns\TextColumn::make('branch.branchname'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(function (Application $record) {
                        return match ($record->status) {
                            'pending' => 'Pending',
                            'approved' => 'Approved',
                            'rejected' => 'Rejected',
                            default => 'Unknown',
                        };
                    }),
                Tables\Columns\TextColumn::make('Dateofapplication'),
            ])
            ->actions([
                Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(function (Application $record) {
                        $record->update(['status' => 'approved']);
                    })
                    ->requiresConfirmation()
                    ->visible(fn(Application $record) => $record->status === 'pending'),

                Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->action(function (Application $record) {
                        $record->applicant->delete(); // Soft deletes the applicant and related records
                    })
                    ->requiresConfirmation()
                    ->visible(fn(Application $record) => $record->status === 'pending'),


                Action::make('restore')
                    ->label('Restore')
                    ->icon('heroicon-o-arrow-narrow-up')
                    ->color('primary')
                    ->action(function (Application $record) {
                        $record->restore(); // Restores the application
                    })
                    ->requiresConfirmation()
                    ->visible(fn(Application $record) => $record->trashed()), // Only visible for trashed records
            ])
            ->filters([
                Tables\Filters\Filter::make('trashed')
                    ->label('Show Deleted Applications')
                    ->query(fn($query) => $query->onlyTrashed()), // Only show soft-deleted records
            ])
            ->bulkActions([
                BulkAction::make('deleteSelected') // Define bulk action correctly
                    ->label('Delete Selected')
                    ->action(function (array $records) {
                        foreach ($records as $record) {
                            $record->delete(); // Soft deletes the selected applications
                        }
                    })
                    ->requiresConfirmation(),
            ]);
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
