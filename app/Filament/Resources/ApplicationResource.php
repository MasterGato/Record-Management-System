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
use Okeonline\FilamentArchivable\Tables\Actions\ArchiveAction;
use Okeonline\FilamentArchivable\Tables\Actions\UnArchiveAction;
use Okeonline\FilamentArchivable\Tables\Filters\ArchivedFilter;
use LaravelArchivable\Scopes\ArchivableScope;
use App\Filament\Exports\ApplicationExporter;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Support\Facades\Response; // Import Response facade
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Branch;

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
                    ->label('Applicant')
                    ->options(fn() => Applicant::all()->pluck('full_name', 'id'))
                    ->required()
                    ->searchable(),

                Forms\Components\Select::make('job_offer_id')
                    ->relationship('jobOffer', 'Job')
                    ->required(),

                Forms\Components\Select::make('branch_id')
                    ->relationship('branch', 'branchname')
                    ->options(fn() => Branch::where('id', Auth::user()->branch_id)->pluck('branchname', 'id'))
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
                        if (!empty($state)) {
                            $applicationId = $get('id');
                            Application::where('id', $applicationId)->update(['status' => 'hired']);

                            Log::info("Application ID: {$applicationId} has changed status to 'hired'.");

                            Notification::make()
                                ->title('Status Updated')
                                ->success()
                                ->body('The application status has been updated to Hired.')
                                ->send();
                        }

                        if ($get('status') === 'completed') {
                            Notification::make()
                                ->title('Control Number Open')
                                ->info()
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
            ->headerActions([
                Action::make('show_hired_report') // New header action for report
                    ->label('Show Hired Applicants Report') // Button label
                    ->action(function () {
                        $hiredApplications = Application::where('status', 'hired')->with('applicant')->get();

                        // Create the PDF view with the hired applications data
                        $pdf = Pdf::loadView('reports.hired_applicants_report', compact('hiredApplications'))
                            ->setPaper('a4', 'portrait'); // Set paper size and orientation

                        // Stream the PDF download
                        return response()->streamDownload(
                            fn() => print($pdf->output()),
                            'hired_applicants_report.pdf'
                        );
                    })
            ])
            ->actions([
                ArchiveAction::make()
                    ->hiddenLabel()
                    ->tooltip('Archive'),

                UnArchiveAction::make()
                    ->hiddenLabel()
                    ->tooltip('Unarchive'),

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
                        $record->update(['status' => 'rejected']);
                        $record->archive(); // Archive instead of delete
                    })
                    ->requiresConfirmation()
                    ->visible(fn(Application $record) => Auth::user()->role === 'MANAGER' && $record->status === 'pending'),
            ])
            ->filters([
                ArchivedFilter::make(), // Add archived filter to show archived records
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->searchable(); // Search the full name column
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('branch_id', Auth::user()->branch_id) // Filter by user's branch ID
            ->withoutGlobalScopes([SoftDeletingScope::class, ArchivableScope::class]);
    }

    public static function getRelations(): array
    {
        return [];
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
