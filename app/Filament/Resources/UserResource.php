<?php

namespace App\Filament\Resources;

use App\Filament\Exports\UserExporter;
use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use App\Models\Branch;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use App\Filament\Exports\UserExporterxporter;
use Filament\Tables\Actions\ExportAction;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Tables\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;


class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'User Management';
    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Username')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('firstname')
                ->maxLength(255)
                ->default(null),
            Forms\Components\TextInput::make('lastname')
                ->maxLength(255)
                ->default(null),
            Forms\Components\TextInput::make('middlename')
                ->maxLength(255)
                ->default(null),
            Forms\Components\TextInput::make('gender')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('contact')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255),
            Forms\Components\DateTimePicker::make('email_verified_at'),
            Forms\Components\TextInput::make('password')
                ->password()
                ->required()
                ->maxLength(255),
            Select::make('role') 
                ->options(User::ROLES) // Ensure User::ROLES is defined properly
                ->required(),
            Select::make('branch_id')
                ->label('Branch')
                ->options(Branch::pluck('branchname', 'id')->toArray()) // Use 'id' for branch ID
                ->native(false)
                ->required(),
            Forms\Components\TextInput::make('status')
                ->required()
                ->maxLength(255),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
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
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])
        ->headerActions([
            // Export as PDF action
            Action::make('export_pdf')
                ->label('Download PDF Report')
                ->action(function () {
                    // Get all active users
                    $employees = User::with('branch')
                                    ->where('status', 'active') // Filter active users
                                    ->get();

                    // Create PDF from the Blade view
                    $pdf = Pdf::loadView('reports.users', compact('employees'));

                    // Return PDF download response
                    return response()->streamDownload(
                        fn () => print($pdf->output()),
                        'active_users_report.pdf'
                    );
                })
                // Optional: Add an icon
                ->color('success'), // Optional: Add button color
        ])
        ->filters([
          
        ])
        ->actions([
            Tables\Actions\Action::make('changeStatus')
                ->label('Change Status')
                ->action(function (User $record) {
                    $record->status = $record->status === 'active' ? 'inactive' : 'active'; // Toggle status
                    $record->save();
                })
                ->requiresConfirmation() // Add confirmation
                ->modalHeading('Confirm Status Change')
                ->modalSubheading('Are you sure you want to change the user status?')
                ->modalButton('Yes, change status')
                ->color('warning'), // Optional: Change color for visibility
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
