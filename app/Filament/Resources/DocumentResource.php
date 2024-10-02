<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentResource\Pages;
use App\Models\Document;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Illuminate\Support\Facades\Storage;
use App\Rules\CorrectFileName;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;
    protected static ?string $navigationIcon = 'heroicon-o-document';
    protected static ?int $navigationSort = 8;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('applicant_id')
                    ->label('Applicant')
                    ->relationship('applicant', 'Firstname'), // Adjust to your full name accessor


                // File uploads for each document with custom validation
                Forms\Components\FileUpload::make('valid_id')
                    ->label('Valid ID')

                    ->disk('public')
                    ->directory('documents/valid_id')
                    ->preserveFilenames()
                    ->rules(['required', 'file', 'max:5120', 'mimes:jpg,jpeg,png,pdf', new CorrectFileName('valid_id')]), // Custom validation rule

                Forms\Components\FileUpload::make('birth_certificate')
                    ->label('Birth Certificate')

                    ->disk('public')
                    ->directory('documents/birth_certificate')
                    ->preserveFilenames()
                    ->rules(['required', 'file', 'max:5120', 'mimes:jpg,jpeg,png,pdf', new CorrectFileName('birth_certificate')]), // Custom validation rule

                Forms\Components\FileUpload::make('medical_certificate')
                    ->label('Medical Certificate')

                    ->disk('public')
                    ->directory('documents/medical_certificate')
                    ->preserveFilenames()
                    ->rules(['required', 'file', 'max:5120', 'mimes:jpg,jpeg,png,pdf', new CorrectFileName('medical_certificate')]), // Custom validation rule

                Forms\Components\FileUpload::make('nbi_clearance')
                    ->label('NBI Clearance')

                    ->disk('public')
                    ->directory('documents/nbi_clearance')
                    ->preserveFilenames()
                    ->rules(['required', 'file', 'max:5120', 'mimes:jpg,jpeg,png,pdf', new CorrectFileName('nbi_clearance')]), // Custom validation rule

                Forms\Components\FileUpload::make('marriage_certificate')
                    ->label('Marriage Certificate')
                    ->disk('public')
                    ->directory('documents/marriage_certificate')
                    ->nullable()
                    ->preserveFilenames()
                    ->rules(['file', 'max:5120', 'mimes:jpg,jpeg,png,pdf', new CorrectFileName('marriage_certificate')]), // Custom validation rule

                Forms\Components\FileUpload::make('passport')
                    ->label('Passport')

                    ->disk('public')
                    ->directory('documents/passport')
                    ->preserveFilenames()
                    ->rules(['required', 'file', 'max:5120', 'mimes:jpg,jpeg,png,pdf', new CorrectFileName('passport')]), // Custom validation rule

                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->nullable(),

                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                    ])
                    ->default('pending')
                    ->disabled(), // The status will be automatically updated
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('applicant.Firstname')->label('Applicant')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('valid_id')
                    ->label('Valid ID')
                    ->formatStateUsing(fn($state) => pathinfo($state, PATHINFO_FILENAME)) // Show only the filename
                    ->url(fn($record) => $record->valid_id ? Storage::url($record->valid_id) : null)
                    ->html() // Allows HTML rendering
                    ->formatStateUsing(fn($state, $record) => $record->valid_id ? '<a href="' . Storage::url($record->valid_id) . '" target="_blank">' . pathinfo($state, PATHINFO_FILENAME) . '</a>' : ''), // Open in new tab
                Tables\Columns\TextColumn::make('birth_certificate')
                    ->label('Birth Certificate')
                    ->formatStateUsing(fn($state) => pathinfo($state, PATHINFO_FILENAME))
                    ->url(fn($record) => $record->birth_certificate ? Storage::url($record->birth_certificate) : null)
                    ->html()
                    ->formatStateUsing(fn($state, $record) => $record->birth_certificate ? '<a href="' . Storage::url($record->birth_certificate) . '" target="_blank">' . pathinfo($state, PATHINFO_FILENAME) . '</a>' : ''), // Open in new tab
                Tables\Columns\TextColumn::make('medical_certificate')
                    ->label('Medical Certificate')
                    ->formatStateUsing(fn($state) => pathinfo($state, PATHINFO_FILENAME))
                    ->url(fn($record) => $record->medical_certificate ? Storage::url($record->medical_certificate) : null)
                    ->html()
                    ->formatStateUsing(fn($state, $record) => $record->medical_certificate ? '<a href="' . Storage::url($record->medical_certificate) . '" target="_blank">' . pathinfo($state, PATHINFO_FILENAME) . '</a>' : ''), // Open in new tab
                Tables\Columns\TextColumn::make('nbi_clearance')
                    ->label('NBI Clearance')
                    ->formatStateUsing(fn($state) => pathinfo($state, PATHINFO_FILENAME))
                    ->url(fn($record) => $record->nbi_clearance ? Storage::url($record->nbi_clearance) : null)
                    ->html()
                    ->formatStateUsing(fn($state, $record) => $record->nbi_clearance ? '<a href="' . Storage::url($record->nbi_clearance) . '" target="_blank">' . pathinfo($state, PATHINFO_FILENAME) . '</a>' : ''), // Open in new tab
                Tables\Columns\TextColumn::make('marriage_certificate')
                    ->label('Marriage Certificate')
                    ->formatStateUsing(fn($state) => pathinfo($state, PATHINFO_FILENAME))
                    ->url(fn($record) => $record->marriage_certificate ? Storage::url($record->marriage_certificate) : null)
                    ->html()
                    ->formatStateUsing(fn($state, $record) => $record->marriage_certificate ? '<a href="' . Storage::url($record->marriage_certificate) . '" target="_blank">' . pathinfo($state, PATHINFO_FILENAME) . '</a>' : ''), // Open in new tab
                Tables\Columns\TextColumn::make('passport')
                    ->label('Passport')
                    ->formatStateUsing(fn($state) => pathinfo($state, PATHINFO_FILENAME))
                    ->url(fn($record) => $record->passport ? Storage::url($record->passport) : null)
                    ->html()
                    ->formatStateUsing(fn($state, $record) => $record->passport ? '<a href="' . Storage::url($record->passport) . '" target="_blank">' . pathinfo($state, PATHINFO_FILENAME) . '</a>' : ''), // Open in new tab
                Tables\Columns\TextColumn::make('status')->label('Status'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }
    
    public static function getMessages(): array
    {
        return [
            'valid_id.required' => 'You must upload a valid ID.',
            'valid_id.file' => 'The valid ID must be a valid file.',
            'valid_id.max' => 'The valid ID must not be greater than 5 MB.',
            'valid_id.mimes' => 'The valid ID must be a file of type: jpg, jpeg, png, pdf.',

            'birth_certificate.required' => 'You must upload a birth certificate.',
            'medical_certificate.required' => 'You must upload a medical certificate.',
            'nbi_clearance.required' => 'You must upload an NBI clearance.',
            'passport.required' => 'You must upload a passport.',
        ];
    }
    protected static function afterCreate(Document $document): void
    {
        $document->checkCompletion();
    }

    protected static function afterUpdate(Document $document): void
    {
        $document->checkCompletion();
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }
}
