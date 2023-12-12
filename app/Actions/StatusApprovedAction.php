<?php

namespace App\Actions;

use App\Enums\TalkStatus;
use Filament\Actions\Concerns\CanCustomizeProcess;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class StatusApprovedAction extends Action
{
    use CanCustomizeProcess;

    public static function getDefaultName(): ?string
    {
        return 'approved';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('Approved'));

        $this->modalHeading(fn (): string => __('Approved'));

        $this->modalSubmitActionLabel(__('Approved'));

        $this->successNotificationTitle(__('Approved'));

        $this->color('success');

        $this->icon('heroicon-o-check-circle');

        $this->requiresConfirmation();

        $this->modalIcon('heroicon-o-check-circle');

        $this->action(function (): void {
            $result = $this->process(static fn (Model $record) => $record->approved());

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
                ->title('This Talk Was Approved')
                ->body('The Speaker Has Been Notified And The Talk Has Been Added To The Schedule')
                ->send();
        });

        $this->hidden(function (Model $record) {
            return $record->status === TalkStatus::APPROVED;
        });
    }
}
