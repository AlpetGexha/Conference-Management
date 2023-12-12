<?php

namespace App\Models;

use App\Enums\TalkLenght;
use App\Enums\TalkStatus;
use App\Traits\WithStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Talk extends Model
{
    use HasFactory, WithStatus;

    protected $casts = [
        'length' => TalkLenght::class,
        'status' => TalkStatus::class,
    ];

    public function speaker(): BelongsTo
    {
        return $this->belongsTo(Speaker::class);
    }

    public function conferences(): BelongsToMany
    {
        return $this->belongsToMany(Conference::class);
    }
}
