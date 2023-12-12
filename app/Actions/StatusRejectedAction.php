<?php

namespace App\Actions;

use App\Enums\TalkStatus;
use Filament\Actions\Concerns\CanCustomizeProcess;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class StatusRejectedAction extends Action
{
    use CanCustomizeProcess;

    public static function getDefaultName(): ?string
    {
        return 'rejected';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('Rejected'));

        $this->modalHeading(fn (): string => __('Rejected'));

        $this->modalSubmitActionLabel(__('Rejected'));

        $this->successNotificationTitle(__('Rejected'));

        $this->color('danger');

        $this->icon('heroicon-o-x-circle');

        $this->requiresConfirmation();

        $this->modalIcon('heroicon-o-x-circle');

        $this->action(function (): void {
            $result = $this->process(static fn (Model $record) => $record->rejected());

            if (! $result) {
                $this->failure();

                return;
            }

            $this->success();
        });

        $this->after(function () {
            Notification::make()
                ->duration(1000)
                ->danger()
                ->title('This Talk Was Rejected')
                ->body('The Speaker Has Been Notified')
                ->send();
        });

        $this->hidden(function (Model $record) {
            return $record->status === TalkStatus::REJECTED;
        });
    }
}
