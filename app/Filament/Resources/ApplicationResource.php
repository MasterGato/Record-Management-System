<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApplicationResource\Pages;
use App\Models\Application;
use App\Models\Applicant;
use App\Models\JobOffer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

                // Use a custom query for the applicant select
                Forms\Components\Select::make('applicant_id')
                    ->label('Applicant')
                    ->options(fn() => Applicant::all()->pluck('full_name', 'id')) // Get all applicants and use their full name
                    ->required()
                    ->searchable(),

                Forms\Components\Select::make('job_offer_id')
                    ->relationship('jobOffer', 'Job')
                    ->required(),

                Forms\Components\Select::make('branch_id')
                    ->relationship('branch', 'branchname')
                    ->required(),

                Forms\Components\DatePicker::make('Dateofapplication')
                    ->default(now())
                    ->required(),

                Forms\Components\TextInput::make('Controlnumber')
                    ->label('Control Number')
                    ->required()
                    ->visible(fn(?Application $record): bool => $record?->status === 'completed')
                    ->maxLength(7)
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        // Check if control number is entered
                        if (!empty($state)) {
                            // Update the status to 'hired'
                            $applicationId = $get('id'); // Get the application ID

                            // Update the application status in the database
                            Application::where('id', $applicationId)->update(['status' => 'hired']);

                            // Log the status change
                            Log::info("Application ID: {$applicationId} has changed status to 'hired'.");

                            // Notify user about the status update
                            Notification::make()
                                ->title('Status Updated')
                                ->success()
                                ->body('The application status has been updated to Hired.')
                                ->send();
                        }

                        // Notify when the status is changed to 'completed'
                        if ($get('status') === 'completed') {
                            Notification::make()
                                ->title('Control Number Open')
                                ->info() // Change to info() for informational notification
                                ->body('The control number is now open.')
                                ->send();
                        }
                    }),
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

                Tables\Columns\TextColumn::make('Typeofapplication'),

                Tables\Columns\TextColumn::make('applicant.fullname')
                    ->label('Full Name')
                    ->formatStateUsing(function ($state, Application $record) {
                        return $record->applicant->Firstname . ' ' . $record->applicant->Lastname;
                    })
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('jobOffer.Job'),

                Tables\Columns\TextColumn::make('branch.branchname'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(function (Application $record) {
                        return match ($record->status) {
                            'pending' => 'Pending',
                            'approved' => 'Approved',
                            'completed' => 'Completed',
                            'hired' => 'Hired',
                            'rejected' => 'Rejected',
                            default => 'Unknown',
                        };
                    }),

                Tables\Columns\TextColumn::make('Dateofapplication'),

                Tables\Columns\TextColumn::make('Controlnumber'),
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
                    ->visible(fn(Application $record) => Auth::user()->role === 'MANAGER' && $record->status === 'pending'),

                Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->action(function (Application $record) {
                        $record->delete(); // Soft delete the application
                    })
                    ->requiresConfirmation()
                    ->visible(fn(Application $record) => Auth::user()->role === 'MANAGER' && $record->status === 'pending'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->bulkActions([])
            ->searchable() // Enable global search
            ->defaultSort('id', 'desc'); // Optional: Set a default sorting
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
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
