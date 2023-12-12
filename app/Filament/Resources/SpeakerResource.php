<?php

namespace App\Filament\Resources;

use App\Enums\TalkStatus;
use App\Filament\Resources\SpeakerResource\Pages;
use App\Filament\Resources\SpeakerResource\RelationManagers\ConferencesRelationManager;
use App\Filament\Resources\SpeakerResource\RelationManagers\TalkRelationManager;
use App\Models\Speaker;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SpeakerResource extends Resource
{
    protected static ?string $model = Speaker::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(self::getForm());
    }

    public static function getForm(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
            Forms\Components\SpatieMediaLibraryFileUpload::make('avatar')
                ->maxSize(1024 * 1024 * 10)
                ->maxFiles(1)
                ->avatar()
                ->image()
                ->imageEditor()
                ->responsiveImages()
                ->collection('avatars'),

            Forms\Components\TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255),
            Forms\Components\MarkdownEditor::make('bio')
                ->required()
                ->maxLength(65535)
                ->columnSpanFull(),
            Forms\Components\TextInput::make('twitter_handle')
                ->required()
                ->maxLength(255),
            Forms\Components\CheckboxList::make('qualification')
                ->options(self::qualification())
                ->descriptions(self::qualificationDescription())
                ->searchable()
                ->required()
                ->columnSpanFull()
                ->columns(3),
        ];
    }

    public static function qualification(): array
    {
        return [
            'business-leader' => 'Business Leader',
            'charisma' => 'Charismatic Speaker',
            'first-time' => 'First Time Speaker',
            'hometown-hero' => 'Hometown Hero',
            'humanitarian' => 'Works in Humanitarian Field',
            'laracasts-contributor' => 'Laracasts Contributor',
            'twitter-influencer' => 'Large Twitter Following',
            'youtube-influencer' => 'Large YouTube Following',
            'open-source' => 'Open Source Creator / Maintainer',
            'unique-perspective' => 'Unique Perspective',
        ];
    }

    public static function qualificationDescription(): array
    {
        return [
            'business-leader' => 'Has been a business leader for at least 5 years.',
            'charisma' => 'Has a charismatic speaking style.',
            'first-time' => 'Has never spoken at a conference before.',
            'laracasts-contributor' => 'Has contributed to Laracasts.',
            'twitter-influencer' => 'Has a large following on Twitter.',
            'youtube-influencer' => 'Has a large following on YouTube.',
            'open-source' => 'Is an open source creator or maintainer.',
            'unique-perspective' => 'Has a unique perspective to share.',
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('twitter_handle')
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
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Personal Information')
                    ->columns(3)
                    ->schema([
                        SpatieMediaLibraryImageEntry::make('avatar')
                            ->collection('avatars')
                            ->circular(),
                        Group::make()
                            ->columnSpan(2)
                            ->columns(2)
                            ->schema([
                                TextEntry::make('name'),
                                TextEntry::make('email'),
                                TextEntry::make('twitter_handle')
                                    ->label('Twitter')
                                    ->getStateUsing(function ($record) {
                                        return '@' . $record->twitter_handle;
                                    })
                                    ->url(function ($record) {
                                        return 'https://twitter.com/' . $record->twitter_handle;
                                    }),
                                TextEntry::make('has_spoken')
                                    ->getStateUsing(function ($record) {
                                        return $record->talks()->where('status', TalkStatus::APPROVED)->count()
                                        > 0 ? 'Previous Speaker' : 'Has Not Spoken';
                                    })
                                    ->badge()
                                    ->color(function ($state) {
                                        if ($state === 'Previous Speaker') {
                                            return 'success';
                                        }
                                        return 'primary';
                                    }),
                            ]),
                    ]),
                Section::make('Other Information')
                    ->collapsed(false)
                    ->schema([
                        TextEntry::make('bio')
                            ->markdown(),
                        TextEntry::make('qualification')
                            ->badge(),
                    ])
            ]);
    }


    public static function getRelations(): array
    {
        return [
            TalkRelationManager::class,
            ConferencesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSpeakers::route('/'),
            'create' => Pages\CreateSpeaker::route('/create'),
            'view' => Pages\ViewSpeaker::route('/{record}'),
//            'edit' => Pages\EditSpeaker::route('/{record}/edit'),
        ];
    }
}
