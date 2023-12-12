<?php

namespace App\Filament\Resources;

use App\Actions\ImageGenerateAction;
use App\Actions\StatusAction;
use App\Filament\Resources\TalkResource\Pages;
use App\Models\Talk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class TalkResource extends Resource
{
    protected static ?string $model = Talk::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(static::getForm())
            ->columns(3);
    }

    public static function getForm($speaker_id = null): array
    {
        return [
            Forms\Components\Section::make()
                ->schema([
                    Forms\Components\Select::make('speaker_id')
                        ->relationship('speaker', 'name')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->hidden(function () use ($speaker_id) {
                            return $speaker_id !== null;
                        }),
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\MarkdownEditor::make('abstract')
                        ->required()
                        ->maxLength(65535)
                        ->columnSpanFull(),
                ])
                ->columns(2)
                ->columnSpan(['lg' => fn(?Talk $record) => $record === null ? 3 : 2]),

            Forms\Components\Section::make()
                ->schema([
                    Forms\Components\Placeholder::make('created_at')
                        ->label('Created at')
                        ->content(fn(Talk $record): ?string => $record->created_at?->diffForHumans()),

                    Forms\Components\Placeholder::make('updated_at')
                        ->label('Last modified at')
                        ->content(fn(Talk $record): ?string => $record->updated_at?->diffForHumans()),
                ])
                ->columnSpan(['lg' => 1])
                ->hidden(fn(?Talk $record) => $record === null),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('speaker.avatar')
                    ->circular()
                    ->collection('avatars')
                    ->defaultImageUrl(function (Talk $record) {
                        return ImageGenerateAction::handle(urlencode($record->speaker->name));
                    }),
                Tables\Columns\TextColumn::make('title')
                    ->sortable()
                    ->searchable()
                    ->description(function (Talk $record) {
                        return Str::of($record->abstract)->limit(45);
                    }),
                Tables\Columns\TextColumn::make('speaker.name')
                    ->sortable(),
                Tables\Columns\IconColumn::make('new_talk')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge(),
                Tables\Columns\IconColumn::make('length')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('new_talk'),
                Tables\Filters\SelectFilter::make('speaker')
                    ->relationship('speaker', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload(),
                //                Tables\Filters\Filter::make('speaker.avatar')
                //                     ->label('Has Avatar')
                //                    ->query(function ($query) {
                //                        return $query->whereHas('speaker.media', function ($query) {
                //                            return $query->where('collection_name', 'avatars');
                //                        });
                //                    })
                //                    ->toggle()

            ])
            ->actions([
                Tables\Actions\EditAction::make()->slideOver(),
                Tables\Actions\DeleteAction::make(),
//                Tables\Actions\ActionGroup::make([
//                    //                    Tables\Actions\ViewAction::make(),
//                    StatusApprovedAction::make(),
//                    StatusSubmittedAction::make(),
//                    StatusRejectedAction::make(),
//                ]),
                StatusAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->persistFiltersInSession();
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
            'index' => Pages\ListTalks::route('/'),
            'create' => Pages\CreateTalk::route('/create'),
            'view' => Pages\ViewTalk::route('/{record}'),
            'edit' => Pages\EditTalk::route('/{record}/edit'),
        ];
    }
}
