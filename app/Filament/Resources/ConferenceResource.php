<?php

namespace App\Filament\Resources;

use App\Enums\Region;
use App\Enums\Status;
use App\Filament\Resources\ConferenceResource\Pages;
use App\Models\Conference;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ConferenceResource extends Resource
{
    protected static ?string $model = Conference::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Conference Details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Conference Name')
                            ->default('My Conference')
                            ->helperText('The name of the conference.')
                            ->required()
                            ->maxLength(60)
                            ->columnSpanFull(),
                        Forms\Components\MarkdownEditor::make('description')
                            ->helperText('What is the conference about?')
                            ->columnSpanFull(),
                        Forms\Components\DatePicker::make('start_date')
                            ->native(false)
                            ->required(),
                        Forms\Components\DateTimePicker::make('end_date')
                            ->native(false)
                            ->required(),

                        Forms\Components\Fieldset::make('status')
                            ->label('Status')
                            ->columns(1)
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->options(Status::class)
                                    ->required(),
                                Forms\Components\Toggle::make('is_published')
                                    ->default(true),
                            ]),
                    ])
                    ->columns(2)
                    ->collapsed(false)
                    ->description('The conference details.'),
                //                    ->icon('heroicon-o-information-circle'),

                Forms\Components\Section::make('Location')
                    ->schema([
                        Forms\Components\Select::make('region')
                            ->enum(Region::class)
                            ->options(Region::class)
                            ->reactive()
                            ->required(),
                        Forms\Components\Select::make('venue_id')
                            ->relationship('venue', 'name', fn(Builder $query, Forms\Get $get) => $query->where('region', $get('region')))
                            ->createOptionForm(VenueResource::getForm())
                            ->editOptionForm(VenueResource::getForm())
                            ->searchable()
                            ->preload()
                            ->required(),
                    ])
                    ->columns(2)
                    ->collapsed(false),

                Forms\Components\Section::make('Thumbnail')
                    ->schema([
                        Forms\Components\SpatieMediaLibraryFileUpload::make('thumbnail')
                            ->label('Thumbnail for the conference')
                            ->maxSize(1024 * 1024 * 10)
                            ->maxFiles(1)
                            ->image()
                            ->imageEditor()
                            ->responsiveImages()
                            ->collection('avatars')
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull()
                    ->collapsed(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->description(function (Conference $record) {
                        return Str::of($record->description)->limit(45);
                    }),
                Tables\Columns\TextColumn::make('start_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('region')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('venue.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('attendees_count')
                    ->label('People Attending')
                    ->counts('attendees')
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make()->slideOver(),
                    Tables\Actions\DeleteAction::make()->requiresConfirmation()
                ])
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
            'index' => Pages\ListConferences::route('/'),
            'create' => Pages\CreateConference::route('/create'),
            'edit' => Pages\EditConference::route('/{record}/edit'),
            'view' => Pages\ViewConference::route('/{record}'),
        ];
    }
}
