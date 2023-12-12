<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;

enum Region: string implements HasColor, HasIcon
{
    case US = 'us';

    case EU = 'eu';

    case AU = 'au';

    case INDIA = 'india';
    case ONLINE = 'online';

    public function getColor(): string
    {
        return match ($this) {
            self::US => 'success',
            self::EU => 'primary',
            self::AU => 'info',
            self::INDIA => 'danger',
            self::ONLINE => 'gray',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::US => 'heroicon-o-flag',
            self::EU => 'heroicon-o-flag',
            self::AU => 'heroicon-o-flag',
            self::INDIA => 'heroicon-o-flag',
            self::ONLINE => 'heroicon-o-globe-alt',
        };
    }
}
