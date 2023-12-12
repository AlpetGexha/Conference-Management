<?php

namespace App\Actions;

use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class StatusAproveAction extends Action
{

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('Aprovar'));

        $this->modalHeading(fn(): string => __('Aprovar'));

        $this->modalSubmitActionLabel(__('Aprovar'));

        $this->successNotificationTitle(__('Aprovar'));

        $this->color('success');

        $this->icon('heroicon-o-check-circle');

        $this->requiresConfirmation();

        $this->modalIcon('heroicon-o-check-circle');

        $this->action(function (): void {
            $result = $this->process(static fn(Model $record) => $record->approved());

            if (!$result) {
                $this->failure();

                return;
            }

            $this->success();
        });
    }
}
