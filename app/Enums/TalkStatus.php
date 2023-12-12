<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;

enum TalkStatus: string implements HasColor, HasIcon
{
    case SUBMITTED = 'Submitted';
    case APPROVED = 'Approved';
    case REJECTED = 'Rejected';

    public function getColor(): string
    {
        return match ($this) {
            self::APPROVED => 'success',
            self::SUBMITTED => 'primary',
            self::REJECTED => 'danger',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::APPROVED => 'heroicon-o-check-circle',
            self::SUBMITTED => 'heroicon-o-clock',
            self::REJECTED => 'heroicon-o-x-circle',
        };
    }
}
