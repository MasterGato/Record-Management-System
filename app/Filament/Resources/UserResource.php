<?php

namespace App\Filament\Resources;

use App\Exports\UserExporter;
use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use App\Models\Branch;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\ExportAction;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\SelectFilter;

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
            Select::make('gender')
                ->label('Gender')
                ->options([
                    'Male' => 'Male',
                    'Female' => 'Female',
                ]),
            Forms\Components\TextInput::make('contact')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255),
            // Conditional rendering for password input
            Forms\Components\TextInput::make('password')
                ->password()
                ->required(fn($record) => is_null($record)) // Only required when creating a new user
                ->maxLength(255)
                ->visible(fn($record) => is_null($record)), // Only visible when creating a new user
            Select::make('role')
                ->options(self::getFilteredRoles()) // Fetch filtered roles
                ->required(),
            Select::make('branch_id')
                ->label('Branch')
                ->options(Branch::pluck('branchname', 'id')->toArray()) // Use 'id' for branch ID
                ->native(false)
                ->required(),
            Forms\Components\Select::make('status')
                ->label('Status')
                ->options([
                    'active' => 'Active',
                    'inactive' => 'Inactive',
                ]),
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
        ])
            ->headerActions([
                // Export as Excel action
                Action::make('export')
                    ->label('Export Users')
                    ->action(function () {
                        return Excel::download(new UserExporter, 'users_report.xlsx');
                    })
            ])
            ->filters([
                SelectFilter::make('branch_id') // Add the branch filter
                    ->label('Branch')
                    ->options(Branch::pluck('branchname', 'id')) // List of branches
                    ->searchable(),
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

    public static function getFilteredRoles(): array
    {
        // Exclude 'admin' from the roles list
        return collect(User::ROLES)->except('admin')->toArray();
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
