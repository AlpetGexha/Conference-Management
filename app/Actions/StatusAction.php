<?php

namespace App\Actions;

use Filament\Tables\Actions\ActionGroup;

class StatusAction
{
    public static function make(): ActionGroup
    {
        return ActionGroup::make([
            StatusApprovedAction::make(),
            StatusRejectedAction::make(),
            StatusSubmittedAction::make(),
        ]);
    }
}
