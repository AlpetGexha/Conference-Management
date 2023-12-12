<?php

namespace App\Actions;

use Filament\Tables\Actions\ActionGroup;

class SatusAction
{

    public static function make(): void
    {
        ActionGroup::make([
            StatusApprovedAction::make(),
            StatusRejectedAction::make(),
            StatusSubmittedAction::make(),
        ]);
    }

}
