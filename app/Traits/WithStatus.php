<?php

namespace App\Traits;

use App\Enums\TalkStatus;

trait WithStatus
{
    public function approved(): void
    {
        $this->update([
            'status' => TalkStatus::APPROVED,
        ]);
    }

    public function submitted(): void
    {
        $this->update([
            'status' => TalkStatus::SUBMITTED,
        ]);
    }

    public function rejected(): void
    {
        $this->update([
            'status' => TalkStatus::REJECTED,
        ]);
    }
}
