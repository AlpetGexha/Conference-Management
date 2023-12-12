<?php

namespace App\Actions;

use App\Enums\TalkStatus;
use Filament\Actions\Concerns\CanCustomizeProcess;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class StatusSubmittedAction extends Action
{
    use CanCustomizeProcess;

    public static function getDefaultName(): ?string
    {
        return 'submitted';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('Submitted'));

        $this->modalHeading(fn (): string => __('Submitted'));

        $this->modalSubmitActionLabel(__('Submitted'));

        $this->successNotificationTitle(__('Submitted'));

        $this->color('primary');

        $this->icon('heroicon-o-check-circle');

        $this->requiresConfirmation();

        $this->modalIcon('heroicon-o-clock');

        $this->action(function (): void {
            $result = $this->process(static fn (Model $record) => $record->submitted());

            if (! $result) {
                $this->failure();

                return;
            }

            $this->success();
        });

        $this->after(function () {
            Notification::make()
                ->duration(1000)
                ->success()
                ->title('This Talk Was Submitted')
                ->body('The Speaker Has Been Notified And The Talk Has Been Added To The Schedule')
                ->send();
        });

        $this->hidden(function (Model $record) {
            return $record->status === TalkStatus::SUBMITTED;
        });
    }
}
