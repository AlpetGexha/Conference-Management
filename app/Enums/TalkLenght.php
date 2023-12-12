<?php

namespace App\Enums;

use Filament\Support\Contracts\HasIcon;

enum TalkLenght: string implements HasIcon
{
    case LIGHTNING = 'Lightning - 15 Minutes';
    case NORMAL = 'Normal - 30 Minutes';
    case KEYNOTE = 'Keynote';

    public function getIcon(): string
    {
        return match ($this) {
            self::LIGHTNING => 'heroicon-o-bolt',
            self::NORMAL => 'heroicon-o-megaphone',
            self::KEYNOTE => 'heroicon-o-key',
        };
    }
}
