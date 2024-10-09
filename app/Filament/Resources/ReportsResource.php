<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportsResource\Pages;
use App\Filament\Resources\ReportsResource\RelationManagers;
use App\Models\Applicant;
use App\Models\Reports;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Redirect;

class ReportsResource extends Resource
{

    protected static ?string $modelLabel = 'Reports';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('reportType')
                    ->label('Type of Report')
                    ->options([
                        'activeuser' => 'Active Users',
                        'rejectedapplicant' => 'Rejected Applicants',
                        'hiredapplicant' => 'Hired Applicants',
                        'listofapplicant' => 'List of Applicants',
                        'returneeapplicant' => 'Returnee Applicants',
                        'branchPerformance' => 'Branch Performance',
                    ])
                    ->required(), // Make it required if necessary
                DatePicker::make('startDate')
                    ->label('Start Date')
                    ->required(),
                DatePicker::make('endDate')
                    ->label('End Date')
                    ->required(),
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
            'index' => Pages\CreateReports::route('/'),
            'create' => Pages\CreateReports::route('/create'),
            'edit' => Pages\EditReports::route('/{record}/edit'),
        ];
    }
}
